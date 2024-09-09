#!/bin/bash
models=("User")
modelsToDispaly=("user")
modelsToFrench=("user")

for model in "${models[@]}"
do

lowerModel=$(echo "$model" | sed 's/^[A-Z]/\L&/')
lowerModelToDispaly=$(echo "$modelsToDispaly" | sed 's/^[A-Z]/\L&/')
# # Generate a model
php artisan make:model $model --migration --seed --resource --policy
php artisan model:filter $model
php artisan make:repository ${model}Repository -i
php artisan make:service ${model}Services/${model}Service

# mkdir  "app/Services/${model}Services"

Generate a Request
  mkdir  "app/Http/Requests/${model}Requests"
  php artisan make:request "${model}Requests/${model}StoreRequest"
  php artisan make:request "${model}Requests/${model}UpdateRequest"


Generate Resource
mkdir  "app/Http/Resources/${model}Resources"
php artisan make:resource ${model}Resources/${model}Resource
php artisan make:resource ${model}Resources/${model}Collection  --collection
php artisan model:filter ${model}
#Create RepositoryInterface
modelRepoInterface="${model}RepositoryInterface"
touch "app/Repositories/Interfaces/${modelRepoInterface}.php"
> "app/Repositories/Interfaces/${modelRepoInterface}.php"

echo "<?php

namespace App\Repositories\Interfaces;

use App\Models\\${model};

interface ${modelRepoInterface}
{
    public function all(\$filters = [], \$with = []);
    public function findById(\$id, \$with= []);
    public function create(array \$data);
    public function update(${model} \$${lowerModel}, array \$data);
    public function delete(${model} \$${lowerModel});
}">> "app/Repositories/Interfaces/${modelRepoInterface}.php"

#Create Repository
modelRepo="${model}Repository"

touch "app/Repositories/${modelRepo}.php"
> "app/Repositories/${modelRepo}.php"
echo "<?php

namespace App\Repositories;

use App\Models\\${model};
use App\Repositories\Interfaces\\${modelRepoInterface};

class ${modelRepo} implements ${modelRepoInterface}
{

    public function __construct(private ${model} \$${lowerModel})
    {
    }

    public function all(\$filters = [], \$with= [])
    {
            return collection(\$this->${lowerModel}, \$filters, \$with);
    }

    public function findById(\$id, \$with= [])
    {
            return \$this->${lowerModel}->with(\$with)->find(\$id);
    }

    public function create(array \$data)
    {
        return \$this->${lowerModel}->create(\$data);
    }

    public function update(${model} \$${lowerModel}, array \$data)
    {
        \$${lowerModel}->update(\$data);
        return \$${lowerModel};
    }

    public function delete(${model} \$${lowerModel})
    {
        \$${lowerModel}->delete();
    }
}">> "app/Repositories/${modelRepo}.php"


# Create a service for the model in the appropriate directory

modelService="${model}Service"
lowerRepoModel="${lowerModel}Repository"

touch "app/Services/${model}Services/${modelService}.php"
> "app/Services/${model}Services/${modelService}.php"
echo "<?php

namespace App\Services\\${model}Services;

use App\Models\\${model};

use App\Repositories\Interfaces\\${modelRepoInterface};

class ${model}Service
{

    public function __construct(private ${modelRepoInterface} \$${lowerRepoModel})
    {
    }

    public function getAll(\$filters = [])
    {
      return \$this->${lowerRepoModel}->all(\$filters, \$filters['with'] ?? []);
    }

    public function findById(\$id, \$with= [])
    {
        return \$this->${lowerRepoModel}->findById(\$id, \$with);
    }

    public function create(array \$data)
    {
        return \$this->${lowerRepoModel}->create(\$data);
    }

    public function update(${model} \$${lowerModel}, array \$data)
    {
        return \$this->${lowerRepoModel}->update(\$${lowerModel}, \$data);
    }

    public function delete(${model} \$${lowerModel})
    {
         \$this->${lowerRepoModel}->delete(\$${lowerModel});
    }

}">> "app/Services/${model}Services/${modelService}.php"


#Create Controller

touch "app/Http/Controllers/${model}Controller.php"
> "app/Http/Controllers/${model}Controller.php"


echo "<?php

namespace App\Http\Controllers;

use App\Models\\${model};
use App\Http\Requests\\${model}Requests\\${model}StoreRequest;
use App\Http\Requests\\${model}Requests\\${model}UpdateRequest;
use App\Http\Resources\\${model}Resources\\${model}Resource;
use App\Http\Resources\\${model}Resources\\${model}Collection;
use App\Services\\${model}Services\\${model}Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ${model}Controller extends Controller
{
    public const NOT_FOUND_MESSAGE = '${modelsToFrench} not found.';

    public function __construct(private ${model}Service \$${lowerModel}Service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request \$request)
    {
        \$this->authorize('viewAny', ${model}::class);

        \$${lowerModel}s = \$this->${lowerModel}Service->getAll(\$request->all());

        return response()->json(
            new ${model}Collection(\$${lowerModel}s)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(${model}StoreRequest \$request): JsonResponse
    {
        \$${lowerModel}= \$this->${lowerModel}Service
            ->create(\$request->validated());

        return response()->json(
            [
                'message' => __('actions.success'),
                'data' => new ${model}Resource(\$${lowerModel})
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function show( \$id, Request \$request): JsonResponse
    {
        \$${lowerModel} = \$this->${lowerModel}Service->findById(\$id, \$request->input('with',[]));
        if (! \$$lowerModel) {
            return response()->json(['message' => self::NOT_FOUND_MESSAGE], 404);
        }
        \$this->authorize('view', \$${lowerModel});

        return response()->json(new ${model}Resource (\$${lowerModel}));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return JsonResponse
     */
    public function update(${model}UpdateRequest \$request, ${model} \$${lowerModel}): JsonResponse
    {
        \$this->${lowerModel}Service->update( \$${lowerModel}, \$request->validated());
        return response()->json([
            'message' => __('actions.success'),
            'data' => new ${model}Resource (\$${lowerModel})
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy(${model} \$${lowerModel}, Request \$request): JsonResponse
    {
        \$this->authorize('delete', \$${lowerModel});

        \$this->${lowerModel}Service->delete(\$${lowerModel});

        return response()->json([ 'message' => __('actions.success')],202);
    }
}" >> "app/Http/Controllers/${model}Controller.php"


#Create Filter Model

touch "app/Http/Filters/${model}Filter.php"
> "app/Http/Filters/${model}Filter.php"
echo "<?php

namespace App\ModelFilters;
use Illuminate\Database\Eloquent\Builder;
use EloquentFilter\ModelFilter;


class ${model}Filter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     *
     */
    public function search(\$value)
    {
        \$query = \$this;
        \$fillableColumns = \$query->getModel()->getFillable();
        return \$query->where(function (Builder \$query) use (\$fillableColumns, \$value) {
            foreach (\$fillableColumns as \$column) {
                \$query->orWhere(\$column, 'LIKE', '%' . \$value . '%');
            }
        });
    }
}" > "app/ModelFilters/${model}Filter.php"


echo "<?php

namespace App\Models;


use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ${model} extends Model
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected \$fillable = [
    ];

}" > "app/Models/${model}.php"


#  Add routes for CRUD operations in your routes file (e.g., api.php or api.php)

  echo    "############################### ${lowerModelToDispaly} ###############################" >> routes/api.php
  echo "Route::prefix('${lowerModelToDispaly}s')->group(function () {
            Route::get('/', [${model}Controller::class, 'index']);
            Route::post('/', [${model}Controller::class, 'store']);
            Route::put('/{${lowerModelToDispaly}}', [${model}Controller::class, 'update']);
            Route::get('/{id}', [${model}Controller::class, 'show']);
            Route::delete('/{${lowerModelToDispaly}}', [${model}Controller::class, 'destroy']);
    });
  " >> routes/api.php
  sed -i "2 a\\use App\\\\Http\\\\Controllers\\\\${model}Controller;
    " "routes/api.php"
  echo "CRUD operations generated for $model."

#RouteServiceProvider
provider_path_route="app/Providers/RouteServiceProvider.php"
binding_line_route="Route::bind('${lowerModelToDispaly}', function (\$value) {try {return ${model}::findOrFail(\$value);} catch (ModelNotFoundException $exception) {abort(404, '${modelsToFrench} not found');}});"



sed -i "/#adding_routes/a\    ${binding_line_route}" "$provider_path_route"
namespace="use App\\\\Models\\\\${model};"
modelNotFound="use Illuminate\\\\Database\\\\Eloquent\\\\ModelNotFoundException;"

sed -i "/#namespace/a\    ${namespace}" "$provider_path_route"

if ! grep -q "${modelNotFound}" "$provider_path_route"; then
sed -i "/#namespace/a\    ${modelNotFound}" "$provider_path_route"
fi

provider_path="app/Providers/AppServiceProvider.php"
# Define the interface and implementation
interface="\\\\App\\\\Repositories\\\\Interfaces\\\\${modelRepoInterface}"
serviceBind="\\\\App\\\\Services\\\\Interfaces\\\\${modelRepoInterface}"
implementation="\\\\App\\\\Repositories\\\\${modelRepo}"
# Create the binding line
binding_line="\$this->app->bind(${interface}::class, ${implementation}::class);"
binding_service="\$this->app->bind(\\\\App\\\\Services\\\\${model}Services\\\\${model}Service::class, function (\$app) {return new \\\\App\\\\Services\\\\${model}Services\\\\${model}Service(\$app->make(${interface}::class));});"
sed -i "/BINDING REPOSITORIES/a\    ${binding_line}" "$provider_path"
sed -i "/BINDING SERVICES/a\    ${binding_service}" "$provider_path"


done

#  composer dump-autoload

