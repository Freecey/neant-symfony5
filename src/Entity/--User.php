<?php
//
//namespace App\Entity;
//
//use App\Repository\UserRepository;
//use Doctrine\ORM\Mapping as ORM;
//use Exception;
//use Symfony\Component\Security\Core\User\UserInterface;
//
///**
// * @ORM\Entity(repositoryClass=UserRepository::class)
// */
//class User implements UserInterface,\Serializable
//{
//    /**
//     * @ORM\Id
//     * @ORM\GeneratedValue
//     * @ORM\Column(type="integer")
//     */
//    private $id;
//
//    /**
//     * @ORM\Column(type="string", length=255, unique=true)
//     */
//    private $username;
//
//    /**
//     * @ORM\Column(type="string", length=255, unique=true)
//     */
//    private $email;
//
//    /**
//     * @ORM\Column(type="string", length=255)
//     */
//    private $password;
//
//    /**
//     * @ORM\Column(type="datetime")
//     */
//    private $create_at;
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getUsername(): ?string
//    {
//        return $this->username;
//    }
//
//    public function setUsername(string $username): self
//    {
//        $this->username = $username;
//
//        return $this;
//    }
//
//    public function getEmail(): ?string
//    {
//        return $this->email;
//    }
//
//    public function setEmail(string $email): self
//    {
//        $this->email = $email;
//
//        return $this;
//    }
//
//    public function getPassword(): ?string
//    {
//        return $this->password;
//    }
//
//    public function setPassword(string $password): self
//    {
//        $this->password = $password;
//
//        return $this;
//    }
//
//    public function getCreateAt(): ?\DateTimeInterface
//    {
//        return $this->create_at;
//    }
//
//    public function setCreateAt(\DateTimeInterface $create_at): self
//    {
//        $this->create_at = $create_at;
//
//        return $this;
//    }
//
//    public function getRoles()
//    {
//        return ['ROLE_ADMIN'];
//    }
//
//    public function getSalt()
//    {
//        return null;
//    }
//
//    public function eraseCredentials()
//    {
//    }
//
//    public function serialize()
//    {
//        return serialize([
//            $this->id,
//            $this->username,
//            $this->email,
//            $this->password
//        ]);
//    }
//
//    public function unserialize($serialized)
//    {
//        list(
//            $this->id,
//            $this->username,
//            $this->email,
//            $this->password
//            ) = unserialize($serialized, ['allowed_class' => false]);
//    }
//}
