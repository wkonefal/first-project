<?php

namespace App\Entity;

use App\Repository\ProductCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductCategoryRepository::class)]
class ProductCategory
{
    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[Assert\Unique]
    private Product $product;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'productCategories')]
    #[Assert\Unique]
    private Category $category;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }


    /**
     * @param Product $product
     * @return $this
     */
    public function setProduct(Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function setCategory(Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
