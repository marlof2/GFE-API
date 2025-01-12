<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Establishment extends Model
{
    use SoftDeletes;

    protected $table = "establishment";
    protected $guarded = ['id'];
    protected $fillable = ["name", "type_of_person_id", "cpf", "cnpj", "phone", "responsible_id", ];
    protected $hidden = ["created_at", "updated_at"];


    public  function scopeFiltro($query, $filtro, $page)
    {
        return $query
            ->withTrashed()
            ->with("tipoPessoa")
            ->OrWhere('name', 'LIKE', '%' . $filtro . '%')
            ->OrWhere('cnpj', 'LIKE', '%' . $filtro . '%')
            ->OrWhere('cpf', 'LIKE', '%' . $filtro . '%')
            ->OrWhere('phone', 'LIKE', '%' . $filtro . '%')
            // ->OrWhereRelation('tipoPessoa', 'name', 'LIKE', '%' . $filtro . '%')
            ->paginate($page);
    }

    public function tipoPessoa()
    {
        return $this->hasOne(TypeOfPerson::class, 'id', 'type_of_person_id')->select("id", "name");
    }
    public function responsible()
    {
        return $this->hasOne(User::class, 'id', 'responsible_id')->select("id", "name");
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'establishment_id', 'id')
            ->where('status', 'approved')
            ->where('subscription_end', '>=', now()->startOfDay())
            ->latest();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'establishment_id', 'id')
            ->where('status', 'approved')
            ->latest();
    }


}
