<?php

namespace SON\CatalogoBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use SON\UserBundle\Entity\User;

/**
 * Catalogo
 *
 * @ORM\Table(name="son_catalogo")
 * @ORM\Entity(repositoryClass="SON\CatalogoBundle\Entity\CatalogoRepository")
 */
class Catalogo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text")
     */
    private $descricao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lancamento", type="datetime")
     */
    private $lancamento;

    /**
     * @var string
     *
     * @ORM\Column(name="imageName", type="string", length=255)
     */
    private $imageName;

    /**
     * @ORM\ManyToOne(targetEntity="SON\UserBundle\Entity\User", cascade={"persist"}, inversedBy="catalogos")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $autor;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @var datetime $contentChanged
     *
     * @ORM\Column(name="content_changed", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"title", "body"})
     */
    private $contentChanged;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Catalogo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Catalogo
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set lancamento
     *
     * @param \DateTime $lancamento
     * @return Catalogo
     */
    public function setLancamento($lancamento)
    {
        $this->lancamento = $lancamento;

        return $this;
    }

    /**
     * Get lancamento
     *
     * @return \DateTime 
     */
    public function getLancamento()
    {
        return $this->lancamento;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Catalogo
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param mixed $autor
     */
    public function setAutor(User $autor)
    {
        $this->autor = $autor;
    }

    /**
     * @return mixed
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param \SON\CatalogoBundle\Entity\datetime $contentChanged
     */
    public function setContentChanged($contentChanged)
    {
        $this->contentChanged = $contentChanged;
    }

    /**
     * @return \SON\CatalogoBundle\Entity\datetime
     */
    public function getContentChanged()
    {
        return $this->contentChanged;
    }

    /**
     * @param \SON\CatalogoBundle\Entity\datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \SON\CatalogoBundle\Entity\datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \SON\CatalogoBundle\Entity\datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return \SON\CatalogoBundle\Entity\datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
