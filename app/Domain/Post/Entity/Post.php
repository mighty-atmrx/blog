<?php

namespace App\Domain\Post\Entity;

use App\Domain\Community\Entity\Community;
use App\Domain\User\Entity\User;
use App\Http\Interfaces\PostEntityInterface;
use Carbon\Carbon;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * * @property string $slug
 * * @property string|null $title
 * * @property string|null $content
 * * @property string|null $image
 * * @property int $user_id
 * * @property int $community_id
 * * @property int $views
 * * @property int $likes
 * * @property int $reposts
 * * @property Carbon $created_at
 * * @property Carbon $updated_at
 * * @property Carbon|null $deleted_at
 */
class Post extends Model implements PostEntityInterface
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'image', 'slug', 'user_id',
        'community_id', 'views', 'likes', 'reposts'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getCommunityId(): int
    {
        return $this->community_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function getReposts(): int
    {
        return $this->reposts;
    }

    public function getPublicationDate(): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromMutable($this->created_at);
    }

    public function getModificationDate(): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromMutable($this->updated_at);
    }

    public function getDeletionDate(): ?\DateTimeImmutable
    {
        return $this->deleted_at
            ? \DateTimeImmutable::createFromMutable($this->deleted_at)
            : null;
    }
}
