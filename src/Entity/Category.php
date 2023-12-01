<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\Column]
    #[Assert\Uuid]
    private string $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[ORM\ManyToOne(targetEntity: Category::class)]
    private ?Category $parent = null;

    #[ORM\ManyToMany(targetEntity: ProductCategory::class, mappedBy: 'Category')]
    private Collection $productCategories;

    public function __construct()
    {
        $this->id = Uuid::v6();
        $this->productCategories = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Category|null
     */
    public function getParent(): ?Category
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     * @return $this
     */
    public function setParent(Category $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, ProductCategory>
     */
    public function getProductCategories(): Collection
    {
        return $this->productCategories;
    }

    /**
     * @param ProductCategory $productCategory
     * @return $this
     */
    public function addProductCategory(ProductCategory $productCategory): static
    {
        if (!$this->productCategories->contains($productCategory)) {
            $this->productCategories->add($productCategory);
            $productCategory->addCategory($this);
        }

        return $this;
    }

    /**
     * @param ProductCategory $productCategory
     * @return $this
     */
    public function removeProductCategory(ProductCategory $productCategory): static
    {
        if ($this->productCategories->removeElement($productCategory)) {
            $productCategory->removeCategory($this);
        }

        return $this;
    }
}
