<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Post extends Model
{
    use Sluggable, SluggableScopeHelpers;

    /**
     * @return array{slug: array{source: string}}
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public string $property_belonging_to_post = '';

    public function testMethodReturningCollectionAndModelInUnion(): void
    {
        $collectionOrModel = User::collectionOrModel();

        \PHPStan\dumpType($collectionOrModel);

        if ($collectionOrModel instanceof Model) {
            echo $collectionOrModel->property_belonging_to_post;
        }

        if (is_iterable($collectionOrModel)) {
            foreach ($collectionOrModel as $model) {
                echo $model->property_belonging_to_post;
            }
        }
    }

    public function testMethodReturningCollectionStatic(): void
    {
        $collectionOrModel = User::collectionStatic();

        \PHPStan\dumpType($collectionOrModel);
    }

    public function testThirdPartyLibraryReturningCollectionAndModelInUnion(): void
    {
        // as per https://github.com/cviebrock/eloquent-sluggable/blob/a86500442ae8b1e2d965acb0340a1b867bf6c0f5/src/SluggableScopeHelpers.php#L78
        // the return type of this trait method is:
        // \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
        $post = Post::findBySlugOrFail('slug');

        \PHPStan\dumpType($post);

        if ($post instanceof Model) {
            echo $post->property_belonging_to_post;
        }
    }
}
