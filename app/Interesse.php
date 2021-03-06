<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class Interesse extends Model
{
    protected $fillable = ['descricao', 'slug'];

    public function pessoas()
    {
        return $this->belongsToMany('App\Pessoa', 'pessoas_interesses');
    }

    /**
     * Salva os interesses e retorna os interesses salvos
     * Também verifica se o interesse já está cadastrado e retorna seu ID
     *
     * @param string $interesses String que vem do textarea
     * @return array Contendo os IDs dos interesses da pessoa
     */
    public static function saveMany($interesses)
    {
        // verifica se não preencheu algum interesses
        if (empty($interesses)) {
            return [];
        }

        $interessesIds = [];

        // transforma em array os interesses colocados por linha
        $interessesExplode = explode("\r\n", $interesses);

        foreach ($interessesExplode as $value) {
            $slug = Str::slug($value, '-');
            try {
                // cadastro de interesse
                $interesse = self::create([
                    'descricao' => $value,
                    'slug' => $slug
                ]);
                $interessesIds[] = $interesse->id;
            } catch (QueryException $e) {
                // caso ja existe, retorna o ID do interesse
                $interesse = self::where('slug', $slug)->first();
                $interessesIds[] = $interesse->id;
            }
        }
        return $interessesIds;
    }
}
