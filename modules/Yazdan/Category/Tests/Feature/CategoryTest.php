<?php

namespace Yazdan\Category\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Yazdan\Category\Tests\Helper\CategoryHelperTest;

class CategoryTest extends TestCase
{
    use RefreshDatabase,CategoryHelperTest;

    //index

    public function testIndexMethod()
    {
        $this->actingAsAdmin();

        $this->get(route('admin.categories.index'))
        ->assertOk();
    }

    public function testIndexMethodError()
    {
        $this->actingAsUser();
        $this->get(route('admin.categories.index'))
        ->assertStatus(302);

    }

    //store

    public function testStoreMethod()
    {
        $category = $this->make();
        $this->actingAsAdmin();
        $this->post(route('admin.categories.store',$category));
        $this->assertDatabaseHas('categories',$category);
        $this->assertDatabaseCount('categories',1);
    }

    public function testStoreMethodError()
    {
        $category = $this->make();
        $this->actingAsUser();
        $this->post(route('admin.categories.store',$category));
        $this->assertDatabaseMissing('categories',$category);
        $this->assertDatabaseCount('categories',0);
    }

    //edit

    public function testEditMethod()
    {
        $category = $this->create();
        $this->actingAsAdmin();
        $this->get(route('admin.categories.edit',$category->id))
        ->assertOk();
    }

    public function testEditMethodError()
    {
        $category = $this->create();
        $this->actingAsUser();
        $this->get(route('admin.categories.edit',$category->id))
        ->assertStatus(302);
    }

    // update

    public function testUpdateMethod()
    {
        $category = $this->create();
        $data = $this->make();
        $this->actingAsAdmin();

        $this->put(route('admin.categories.update',$category->id),$data)
        ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories',$data);
        $this->assertDatabaseMissing('categories',$category->toArray());

    }

    public function testUpdateMethodError()
    {
        $category = $this->create();
        $data = $this->make();
        $this->actingAsUser();

        $this->put(route('admin.categories.update',$category->id),$data)
        ->assertStatus(302);

        $this->assertDatabaseMissing('categories',$data);

    }

    //destroy

    public function testDestroyMethod()
    {
        $category = $this->create();
        $this->actingAsAdmin();

        $this->delete(route('admin.categories.destroy',$category->id))
        ->assertOk();

        $this->assertDatabaseMissing('categories',$category->toArray());

    }

    public function testDestroyMethodError()
    {
        $category = $this->create();
        $this->actingAsUser();

        $this->delete(route('admin.categories.destroy',$category->id))
        ->assertStatus(302);

    }
}
