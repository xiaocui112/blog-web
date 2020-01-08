<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['title', 'body',  'category_id',  'excerpt', 'slug'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * 处理排序
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $order
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'recent':
               return $query->recent();
                break;
            default:
               return $query->recentReplied();
                break;
        }
    }
    /**
     * 更新时间排序
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at','desc');
    }
    /**
     * 创建时间排序
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at','desc');
    }
    public function link($params=[])
    {
        return route('topics.show',array_merge([$this->id,$this->slug]));
    }
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
