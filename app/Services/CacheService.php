<?php
namespace App\Services;

class CacheService{

    protected $minutosDuracaoCache = 60;

    public function getMinutosDuracaoCache(){
        return $this->minutosDuracaoCache;
    }
    public function setMinutosDuracaoCache($minutosDuracaoCache){
        $this->minutosDuracaoCache = $minutosDuracaoCache;
    }
    public function getCache($key){
        return cache()->remember($key, $this->getMinutosDuracaoCache(), function () {
            return null;
        });
    }
    public function setCache($key, $value){
        return cache()->put($key, $value, $this->getMinutosDuracaoCache());
    }
    public function clearCache($key){
        return cache()->forget($key);
    }
    public function clearAllCache(){
        return cache()->flush();
    }
}
?>