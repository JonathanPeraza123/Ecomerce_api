<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_a_single_category_whit_types()
    {
        $category = Category::factory()->create();
        $type1 = Type::factory()->create([
            'category_id' => $category->id
        ]);
        $type2 = Type::factory()->create([
            'category_id' => $category->id
        ]);
        Type::factory()->create([
            'name' => 'Other name'
        ]);

        $url = route('categories.show', $category->getRouteKey());

        $reponse = $this->getJson($url)
            ->assertJsonCount(2, 'data')
            ->assertDontSee([
                'name' => 'Other name'
            ]);

        $reponse->assertJsonFragment([
            'data' => [
                [
                    'type' => 'type',
                    'id' => (string) $type1->getRouteKey(),
                    'attributes' => [
                        'name' => $type1->name,
                        'slug' => $type1->slug,
                    ],
                    'links' => [
                        'self' => route('api.v1.show.type', $parameters = [
                            'category' => $type1->category->slug,
                            'type' => $type1->getRouteKey()
                        ])
                    ]
                ],
                [
                    'type' => 'type',
                    'id' => (string) $type2->getRouteKey(),
                    'attributes' => [
                        'name' => $type2->name,
                        'slug' => $type2->slug,
                    ],
                    'links' => [
                        'self' => route('api.v1.show.type', $parameters = [
                            'category' => $type2->category->slug,
                            'type' => $type2->getRouteKey()
                        ])
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_categories()
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        $category3 = Category::factory()->create();
        $category4 = Category::factory()->create();

        $url = route('categories.index');

        $reponse = $this->getJson($url)->assertJsonCount(4, 'data');

        $reponse->assertJsonFragment([
            'data' => [
                [
                    'type' => 'category',
                    'id' => (string) $category1->getRouteKey(),
                    'attributes' => [
                        'name' => $category1->name,
                        'slug' => $category1->slug
                    ],
                    'links' => [
                        'self' => route('categories.show', $category1->getRouteKey())
                    ]
                ],
                [
                    'type' => 'category',
                    'id' => (string) $category2->getRouteKey(),
                    'attributes' => [
                        'name' => $category2->name,
                        'slug' => $category2->slug
                    ],
                    'links' => [
                        'self' => route('categories.show', $category2->getRouteKey())
                    ]
                ],
                [
                    'type' => 'category',
                    'id' => (string) $category3->getRouteKey(),
                    'attributes' => [
                        'name' => $category3->name,
                        'slug' => $category3->slug
                    ],
                    'links' => [
                        'self' => route('categories.show', $category3->getRouteKey())
                    ]
                ],
                [
                    'type' => 'category',
                    'id' => (string) $category4->getRouteKey(),
                    'attributes' => [
                        'name' => $category4->name,
                        'slug' => $category4->slug
                    ],
                    'links' => [
                        'self' => route('categories.show', $category4->getRouteKey())
                    ]
                ]
            ]
        ]);
    }
}
