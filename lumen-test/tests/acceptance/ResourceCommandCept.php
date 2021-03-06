<?php
$I = new AcceptanceTester($scenario);

$I->wantTo('generate a RESTful resource');
$I->runShellCommand('php artisan tdev:resource task_category "name;string:unique;requied;fillable;word descr;text:nullable;;fillable;paragraph due;timestamp;;fillable,date;date" --has-many="tags,tasks" --belongs-to="project,creator:User" --add=timestamps --migration-file=create_task_categories');

// Checking the model
$I->seeInShellOutput('TaskCategory model generated');
$I->seeFileFound('./app/TaskCategory.php');
$I->openFile('./app/TaskCategory.php');

$I->seeInThisFile('namespace App;');
$I->seeInThisFile('class TaskCategory extends Model');
$I->seeInThisFile('protected $fillable = ["name", "descr", "due", "project_id", "user_id"];');
$I->seeInThisFile('protected $dates = ["due"];');
$I->seeInThisFile(
"public static \$rules = [\n".
"        \"name\" => \"requied\"," . PHP_EOL .
"        \"project_id\" => \"required|numeric\"," . PHP_EOL .
"        \"user_id\" => \"required|numeric\",\n".
"    ];");
$I->seeInThisFile(
'    public function tags()
    {
        return $this->hasMany("App\Tag");
    }');
$I->seeInThisFile(
'    public function tasks()
    {
        return $this->hasMany("App\Task");
    }');
$I->seeInThisFile(
'    public function project()
    {
        return $this->belongsTo("App\Project");
    }');
$I->seeInThisFile(
'    public function creator()
    {
        return $this->belongsTo("App\User");
    }');
$I->deleteFile('./app/TaskCategory.php');

// Checking the migration
$I->seeInShellOutput('task_categories migration generated');
$I->seeFileFound('./database/migrations/create_task_categories.php');
$I->openFile('./database/migrations/create_task_categories.php');

$I->seeInThisFile('class CreateTaskCategoriesTable extends Migration');
$I->seeInThisFile("Schema::create('task_categories', function(Blueprint \$table) {\n".
"            \$table->increments('id');\n".
"            \$table->string('name')->unique();" . PHP_EOL .
"            \$table->text('descr')->nullable();" . PHP_EOL .
"            \$table->timestamp('due');" . PHP_EOL .
"            \$table->integer('project_id')->unsigned();" . PHP_EOL.
"            \$table->integer('user_id')->unsigned();\n" .
"            \$table->foreign('project_id')\n".
"                ->references('id')\n".
"                ->on('projects');" . PHP_EOL .
"            \$table->foreign('user_id')\n".
"                ->references('id')\n".
"                ->on('users');\n".
"            \$table->timestamps();");

$I->deleteFile('./database/migrations/create_task_categories.php');

// Checking the RESTActions trait
$I->seeFileFound('./app/Http/Controllers/RESTActions.php');
$I->deleteFile('./app/Http/Controllers/RESTActions.php');

// Checking the controller
$I->seeInShellOutput('TaskCategoriesController generated');
$I->seeFileFound('./app/Http/Controllers/TaskCategoriesController.php');
$I->openFile('./app/Http/Controllers/TaskCategoriesController.php');

$I->seeInThisFile('class TaskCategoriesController extends Controller {

    const MODEL = \'App\TaskCategory\';

    use RESTActions;

}');

$I->deleteFile('./app/Http/Controllers/TaskCategoriesController.php');

// Checking routes
$I->openFile('./routes/web.php');
$I->seeInThisFile('
$app->get(\'task-category\', \'TaskCategoriesController@all\');
$app->get(\'task-category/{id}\', \'TaskCategoriesController@get\');
$app->post(\'task-category\', \'TaskCategoriesController@add\');
$app->put(\'task-category/{id}\', \'TaskCategoriesController@put\');
$app->delete(\'task-category/{id}\', \'TaskCategoriesController@remove\');');
$I->writeToFile('./routes/web.php', '<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get("/", function () use ($app) {
    return $app->welcome();
});
');

// Checking model factory
// $I->openFile('./database/factories/ModelFactory.php');
// $I->seeInThisFile(
// "/**
//  * Factory definition for model App\TaskCategory.
//  */
// \$factory->define(App\TaskCategory::class, function (\$faker) {
//     return [
//      'name' => \$faker->word,
//      'descr' => \$faker->paragraph,
//      'due' => \$faker->date,
//     ];
// });");
$I->writeToFile('./database/factories/ModelFactory.php', "<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

\$factory->define(App\User::class, function (\$faker) {
    return [
        'name' => \$faker->name,
        'email' => \$faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});
");

// Checking database seeder
// $I->openFile('./database/seeds/TaskCategoriesTableSeeder.php');
// $I->seeInThisFile('
// use Illuminate\Database\Seeder;

// class TaskCategoriesTableSeeder extends Seeder
// {
//     public function run()
//     {
//         factory(App\TaskCategory::class, 10)->create();
//     }
// }');
// $I->deleteFile('./database/seeds/TaskCategoriesTableSeeder.php');
