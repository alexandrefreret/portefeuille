<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Schema;
use DB;

use Deiucanta\Smart\Field;
use Deiucanta\Smart\Model;

use App\Helpers\Helper;

/**
 * BaseModel allows soft delete through a prefix_valide column and sets the defaults parameters
 */
abstract class AbstractModel extends Model
{
	protected $connection = "mysql";
	protected $show_timetamps = false;
	/**
	 * Defaults to model_name
	 */
	protected $table = null;
	public $timestamps = false;
	/**
	 * Defaults to <prefix>_id
	 */
	public $primaryKey = null;
	protected $hidden = [];

	public function fields()
	{
		$fields = [
			Field::make($this->prefix().'_id')->increments(),
			Field::make($this->prefix().'_inserted')->timestamp()->useCurrent(),
			Field::make($this->prefix().'_updated')->timestamp()->rawDefault("\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')")
		];

		if ($this->isSoftDeletable()) {
			$fields[] = Field::make($this->prefix().'_valide')
				->boolean()
				->cast(null) // Fix to not convert tinyInt to boolean value
				->default(true)
				->index();
		}

		return $fields;
	}

	// Override this function to edit prefix
	static public function prefix()
	{
		return strtolower(class_basename(static::class));
	}

	/**
	 * Indicates if a valide global scope should be added
	 * Override this method if you want to disable _valide column
	 */
	static public function isSoftDeletable()
	{
		return true;
	}

	/**
	 * Indicates if a user scope should be added when synchronizing
	 */
	static public function hasUser()
	{
		return false;
	}

	/**
	 * Indicates if the table has a lang code column, to perform a language restriction
	 * Override this method with the column name that has the lang code
	 */
	public static function hasLangRestrictionCol()
	{
		return false;
	}

	public function __construct(array $attributes = array())
	{
		if ($this->primaryKey === null)
		{
			$this->primaryKey = static::prefix().'_id';
		}
		if ($this->table === null)
		{
			$this->table = Str::snake(class_basename($this));
		}

		// We should not combine $fillable and $guarded
		if (sizeof($this->fillable) === 0)
		{
			if (sizeof($this->guarded) == 1 && $this->guarded[0] === '*')
			{
				$this->guarded = [];
			}
			$this->guarded[] = $this->primaryKey;
			$this->guarded[] = $this->prefix().'_inserted';
			$this->guarded[] = $this->prefix().'_updated';
		}

		// We guarantee that at least _inserted and _updated fields are hidden
		if (!array_key_exists($this->prefix().'_inserted', $this->hidden) && !$this->show_timetamps)
		{
			$this->hidden[] = $this->prefix().'_inserted';
		}
		if (!array_key_exists($this->prefix().'_updated', $this->hidden) && !$this->show_timetamps)
		{
			$this->hidden[] = $this->prefix().'_updated';
		}

		parent::__construct($attributes);
	}

	protected static function boot()
	{
		parent::boot();

		if (static::isSoftDeletable())
		{
			static::addGlobalScope('valide', function (Builder $builder) {
				$builder->where(static::prefix().'_valide', '=', 1);
			});
		}

		if (static::hasUser())
		{
			static::addGlobalScope('user', function (Builder $builder) {
				$user = auth()->user();
				
				if (!empty($user)) {
					$user_col = static::prefix().'_user';
					$builder->where($user_col, '=', $user->id)
							->orWhere($user_col, '<=', 0);
				}
			});
			
		}
	}

    // Permet d'appliquer un scope à une liste de relations
    public function scopeWithSpecificScope(Builder $builder, $relations, $scopes)
    {
    	$with_relations = [];

    	foreach ($relations as $relation_name => $relation) {
			// On a une relation avec une callback
			if(is_string($relation_name)) {
				$with_relations[$relation_name] = function($query) use ($scopes, $relation) {
					if(!is_array($scopes)) $scopes = [$scopes];
	
					foreach ($scopes as $scopeName) {
						$query->$scopeName();
					}

					// $query->callScope($relation);
					$query->where($relation);
				};
			}
			// On a une relation normale
			else {
				$with_relations[$relation] = function($query) use ($scopes) {
					if(!is_array($scopes)) $scopes = [$scopes];
	
					foreach ($scopes as $scopeName) {
						$query->$scopeName();
					}
				};
			}
    	}

		return $builder->with($with_relations);
    }

    // Permet d'utiliser '->with(relation)' sans les global scope spécifiés
    public function scopeWithButWithoutScope(Builder $builder, $relations, $scope_to_exclude)
    {
    	$with_relations = [];

    	foreach ($relations as $relation) {
    		$with_relations[$relation] = function($query) use ($scope_to_exclude) {

    			if(is_array($scope_to_exclude)) $query->withoutGlobalScopes($scope_to_exclude);
    			else $query->withoutGlobalScope($scope_to_exclude);
			};
    	}

		return $builder->with($with_relations);
    }

	// static public function getUserLang() 
	// {
	// 	$user = auth()->user();
	// 	return $user->lang;
	// }

	public function hasColumn($column)
	{
		return Schema::connection($this->connection)->hasColumn($this->table, $column);
	}

	// Override de cette méthode de SmartModel pour ne pas valider les modèles
	// Problème avec le _valide = 1 qui n'est pas un booléen
    public function validate($skip = [])
    {
        if ($this->validator === null) {
            $data = $this->getValidatorData($skip);
            $this->validator = Validator::make([], []);
        }

        return $this->validator;
    }

    public function removeUnknownAttributes()
    {
    	
	}
	
	public function hasAttribute($attr)
	{
		return array_key_exists($attr, $this->attributes);
	}
}
