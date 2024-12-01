<?php 
 namespace App\Services;


 use App\Repositories\Contracts\CategoryRepositoryInterface;
 use App\Repositories\Contracts\ProductsRepositoryInterface;

 class FrontService{
    protected $categoryRepository;
    protected $productRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository, ProductsRepositoryInterface $productsRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productsRepository;
    }

    public function searchProducts($search)
    {
        return $this->productRepository->searchByName($search);
    }

    public function getFrontPageData(){
        $categories = $this->categoryRepository->getAllCategories();
        $popularProducts = $this->productRepository->getPopularProducts(4);
        $newProducts = $this->productRepository->getAllNewProducts();

        return compact('categories', 'popularProducts', 'newProducts');
    }
 }