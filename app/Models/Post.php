<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
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
}
