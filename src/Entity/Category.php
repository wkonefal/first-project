<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\Uuid]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[ORM\ManyToOne(targetEntity: Category::class)]
    private ?string $parent;

    #[ORM\ManyToMany(targetEntity: ProductCategory::class, mappedBy: 'Category')]
    private Collection $productCategories;

    public function __construct()
    {
        $this->parent = new ArrayCollection();
        $this->productCategories = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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
     * @return Collection<int, Product>
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    /**
     * @param Product $parent
     * @return $this
     */
    public function addParent(Product $parent): static
    {
        if (!$this->parent->contains($parent)) {
            $this->parent->add($parent);
            $parent->setCategory($this);
        }

        return $this;
    }

    /**
     * @param Product $parent
     * @return $this
     */
    public function removeParent(Product $parent): static
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getCategory() === $this) {
                $parent->setCategory(null);
            }
        }

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
