<?php

namespace App\Domain\Post\Entity;

use App\Domain\Community\Entity\Community;
use App\Domain\Post\Enum\StateEnum;
use App\Domain\User\Entity\User;
use App\Http\Trait\HasSlug;
use Database\Factories\PostFactory;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $image
 * @property string $slug
 * @property int $user_id
 * @property int $community_id
 * @property StateEnum $state
 * @property int $views
 * @property int $likes
 * @property int $reposts
 * @property DateTimeImmutable $created_at
 * @property DateTimeImmutable $updated_at
 * @property DateTimeImmutable|null $deleted_at
 */
class Post extends Model
{
    /** @use HasFactory<PostFactory>
     * @use HasSlug
     */
    use HasFactory, HasSlug;

    protected $table = 'posts';
    protected $fillable = [
        'title', 'content', 'image', 'slug', 'user_id',
        'community_id', 'views', 'likes', 'reposts', 'state'
    ];

    protected $casts = [
        'state' => StateEnum::class,
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function incrementViews(): void
    {
        $this->views++;
        $this->updated_at = new DateTimeImmutable();
    }

    public function incrementLikes(): void
    {
        $this->likes++;
        $this->updated_at = new DateTimeImmutable();
    }

    public function incrementReposts(): void
    {
        $this->reposts++;
        $this->updated_at = new DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->getRouteKeyName();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getCommunityId(): ?int
    {
        return $this->community_id;
    }

    public function getState(): StateEnum
    {
        return $this->state;
    }

    public function getViews(): int
    {
        return $this->views ?? 0;
    }

    public function getLikes(): int
    {
        return $this->likes ?? 0;
    }

    public function getReposts(): int
    {
        return $this->reposts ?? 0;
    }

    public function getPublicationDate(): DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getModificationDate(): DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function getDeletionDate(): ?DateTimeImmutable
    {
        return $this->deleted_at;
    }
}
