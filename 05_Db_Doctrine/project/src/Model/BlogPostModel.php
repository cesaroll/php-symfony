<?php
/**
 * @author    Cesar Lopez Lerma <clopezlerma@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */
declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;
use DateTimeInterface;

class BlogPostModel {

    /**
     * @var string
     * @SerializedName("Title")
     */
    private string $title;
    /**
     * @var DateTimeInterface
     * @SerializedName("Title")
     */
    private DateTimeInterface $published;
    /**
     * @var string
     * @SerializedName("Content")
     */
    private string $content;
    /**
     * @var string
     * @SerializedName("Author")
     */
    private string $author;
    /**
     * @var string|null
     * @SerializedName("Slug")
     */
    private ?string $slug;

    /**
     * BlogPost constructor.
     *
     * @param string            $title
     * @param DateTimeInterface $published
     * @param string            $content
     * @param string            $author
     * @param string|null       $slug
     */
    public function __construct(string $title, DateTimeInterface $published, string $content, string $author, ?string $slug) {
        $this->title     = $title;
        $this->published = $published;
        $this->content   = $content;
        $this->author    = $author;
        $this->slug      = $slug;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * @return DateTimeInterface
     */
    public function getPublished(): DateTimeInterface {
        return $this->published;
    }

    /**
     * @param DateTimeInterface $published
     */
    public function setPublished(DateTimeInterface $published): void {
        $this->published = $published;
    }

    /**
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getAuthor(): string {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void {
        $this->author = $author;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void {
        $this->slug = $slug;
    }



}