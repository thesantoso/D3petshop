<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class GramediaCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:gramedia {baseurl} {pagefrom} {pageto}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl gramedia books';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->argument('baseurl');
        $from = $this->argument('pagefrom');
        $to = $this->argument('pageto');

        foreach (range($from, $to) as $p) {
            $this->info("# Page $p");
            $books = $this->getBooks($url, [
                'page' => $p
            ]);

            if (is_array($books)) {
                foreach ($books as $book) {
                    $this->insertBook($book);
                }
            }
        }
    }

    public function getBooks($url, $params)
    {
        $params = http_build_query($params);
        $json = file_get_contents($url.'?'.$params);
        $books = json_decode($json, true);

        return $books;
    }

    public function insertBook(array $data)
    {
        $slug = str_slug(array_get($data, 'name'));
        if (Book::where('slug', $slug)->count()) {
            return $this->info("Book '$slug' exists.");
        }

        $detail = $this->getDetail($data);

        $book = new Book;
        $book->slug = $slug;
        $book->title = array_get($data, 'name');
        $book->price = array_get($data, 'basePrice');
        $book->description = array_get($detail, 'description');
        $book->cover = $this->downloadCover(array_get($data, 'meta.thumbnail'));
        $book->stock = 20;
        $book->save();

        $categories = array_get($detail, 'categories');
        $cat = array_get($categories, 1);
        if ($cat) {
            $cat['slug'] = str_slug($cat['title']);
            $category = Category::where('slug', $cat['slug'])->first();
            if (!$category) {
                $category = new Category;
                $category->name = $cat['title'];
                $category->slug = $cat['slug'];
                $category->save();
            }

            DB::table('book_categories')->insert([
                'book_id' => $book->getKey(),
                'category_id' => $category->getKey(),
            ]);
        }
    }

    public function downloadCover($url)
    {
        $content = file_get_contents($url);
        $filename = pathinfo($url, PATHINFO_BASENAME);
        file_put_contents(public_path('uploads').'/books/'.$filename, $content);

        return $filename;
    }

    public function getDetail(array $data)
    {
        $slug = trim(array_get($data, 'meta.href'), '/');
        $slug = array_last(explode('/', $slug));

        $json = file_get_contents("https://www.gramedia.com/api/products/{$slug}");
        $data = json_decode($json, true);

        return $data;
    }
}
