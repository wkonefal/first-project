<?php

namespace App\Entity;

use App\Repository\ProductCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductCategoryRepository::class)]
class ProductCategory
{
    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\Id]
    private Product $product;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'productCategories')]
    #[ORM\Id]
    private Category $category;

    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
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
    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
