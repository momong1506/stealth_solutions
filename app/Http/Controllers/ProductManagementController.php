<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Categories;
use App\Models\Permissions;
use App\Models\ProductCategories;
use App\Models\Products;
use App\Models\RolePermissions;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductManagementController extends Controller
{
    /**
     * View for Product Categories
     *
     */
    public function categories()
    {
        $categories = Categories::all();

        return view('product_management.categories', [
            'categories' => $categories,
        ]);
    }

    /**
     * View for Product
     *
     */
    public function products()
    {
        $categories = Categories::all();

        $products = Products::with(['productCategories'])->get();

        $compileProductCategories = [];

        foreach ($products as $product) {
            if (!empty($product->productCategories)) {
                $compileCategoryIds = [];

                foreach ($product->productCategories as $productCategory) {
                    $compileCategoryIds[] = $productCategory->categories_id;
                }

                if ($compileCategoryIds) {
                    $categoryInstance = new Categories();
                    $compileProductCategories[] = [
                        'product' => $product,
                        'categories' => $categoryInstance->whereIn('id', $compileCategoryIds)->get(),
                    ];
                }
            }
        }

        return view('product_management.products', [
            'products' => $compileProductCategories,
            'categories' => $categories,
        ]);
    }

    /**
     * Api for create categories
     *
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function createCategory(CategoryRequest $request): JsonResponse
    {
        $categoryInstance = new Categories();
        $created = $categoryInstance->createCategory($request->all());

        return response()->json([
            'message' => $created ? 'Successfully created' : 'Failed to create',
            'code' => $created ? Response::HTTP_CREATED : Response::HTTP_ACCEPTED,
        ]);
    }

    /**
     * Api for updating category
     *
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function updateCategory(UpdateRequest $request): JsonResponse
    {
        $categoryInstance = new Categories();
        $updated = $categoryInstance->updateCategory($request->input('id'), $request->all());

        return response()->json([
            'message' => $updated ? 'Successfully updated' : 'Failed to update',
            'code' => $updated ? Response::HTTP_OK : Response::HTTP_ACCEPTED,
        ]);
    }

    /**
     * Api for deleting category
     *
     * @param DeleteRequest $request
     */
    public function deleteCategory(DeleteRequest $request)
    {
        $recordId = $request->input('id');

        $categoryInstance = new Categories();
        $categoryInstance->deleteCategory($recordId);

        return redirect('categories');
    }

    /**
     * Api for create product
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function createProduct(ProductRequest $request): JsonResponse
    {
        $categoriesData = $request->input('categories');

        $productInstance = new Products();
        $created = $productInstance->createProduct($request->all());

        if (!empty($categoriesData)) {
            foreach ($categoriesData as $category) {
                $productCategoryInstance = new ProductCategories();
                $productCategoriesPayload = [
                    'products_id' => $created->id,
                    'categories_id' => $category,
                ];
                $productCategoryInstance->createProductCategories($productCategoriesPayload);
            }
        }

        return response()->json([
            'message' => $created ? 'Successfully created' : 'Failed to create',
            'code' => $created ? Response::HTTP_CREATED : Response::HTTP_ACCEPTED,
        ]);

    }

    /**
     * Api for updating product
     *
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function updateProduct(UpdateRequest $request): JsonResponse
    {
        $recordId = $request->input('id');

        $categoriesData = $request->input('categories');

        $payload = [
            'role_name' => $request->input('role_name'),
        ];

        $productInstance = new Products();
        $productCategories = new ProductCategories();

        $updated = $productInstance->updateProduct($recordId, $payload);
        $productCategories->deleteProductCategories($recordId);

        if (!empty($categoriesData)) {
            foreach ($categoriesData as $category) {
                $productCategoryInstance = new ProductCategories();
                $productCategoryPayload = [
                    'products_id' => $recordId,
                    'categories_id' => $category,
                ];
                $productCategoryInstance->createProductCategories($productCategoryPayload);
            }
        }

        $categoryInstance = new Products();
        $updated = $categoryInstance->updateProduct($request->input('id'), $request->all());

        return response()->json([
            'message' => $updated ? 'Successfully updated' : 'Failed to update',
            'code' => $updated ? Response::HTTP_OK : Response::HTTP_ACCEPTED,
        ]);
    }

    /**
     * Api for deleting product
     *
     * @param DeleteRequest $request
     */
    public function deleteProduct(DeleteRequest $request)
    {
        $recordId = $request->input('id');

        $productInstance = new Products();
        $productInstance->deleteProduct($recordId);

        return redirect('products');
    }
}