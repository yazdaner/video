<?php

namespace Yazdan\Discount\Repositories;

use Morilog\Jalali\Jalalian;
use Yazdan\Discount\App\Models\Discount;

class DiscountRepository
{
    const TYPE_ALL = "all";
    const TYPE_SPECIAL = "special";
    public static $types = [
        self::TYPE_ALL,
        self::TYPE_SPECIAL
    ];
    public static function find($id)
    {
        return Discount::query()->find($id);
    }
    public static function store($data)
    {
        $discount = Discount::query()->create([
            "user_id" => auth()->id(),
            "code" => $data["code"],
            "percent" => $data["percent"],
            "usage_limitation" => $data["usage_limitation"],
            "expire_at" => $data["expire_at"] ? Jalalian::fromFormat("Y/m/d H:i", $data["expire_at"])->toCarbon() : null,
            "link" => $data["link"],
            "type" => $data["type"],
            "description" => $data["description"],
            "uses" => 0
        ]);

        if ($discount->type == self::TYPE_SPECIAL) {
            $discount->courses()->sync($data["courses"]);
        }
    }

    public static function paginateAll()
    {
        return Discount::query()->latest()->paginate();
    }

    public static function update($id, array $data)
    {
        Discount::query()->where("id", $id)->update([
            "code" => $data["code"],
            "percent" => $data["percent"],
            "usage_limitation" => $data["usage_limitation"],
            "expire_at" => $data["expire_at"] ? Jalalian::fromFormat("Y/m/d H:i", $data["expire_at"])->toCarbon() : null,
            "link" => $data["link"],
            "type" => $data["type"],
            "description" => $data["description"],
        ]);

        $discount = self::find($id);
        if ($discount->type == self::TYPE_SPECIAL) {
            $discount->courses()->sync($data["courses"]);
        } else {
            $discount->courses()->sync([]);
        }
    }


    public function getValidDiscountsQuery($type = "all", $id = null)
    {
        $query = Discount::query()
            ->where("expire_at", ">", now())
            ->where("type", $type)
            ->whereNull("code");
        if (!is_null($id)) {
            $query->whereHas("courses", function ($query) use ($id) {
                $query->where("id", $id);
            });
        }

        $query->where(function ($query) {
            $query->where("usage_limitation", ">", "0")
                ->orWhereNull("usage_limitation");
        })
            ->orderBy("percent", "desc");

        return $query;
    }

    public function getGlobalBiggerDiscount()
    {
        return $this->getValidDiscountsQuery()
            ->first();
    }

    public function getCourseBiggerDiscount($id)
    {
        return $this->getValidDiscountsQuery(DiscountRepository::TYPE_SPECIAL, $id)->first();
    }

    public static function getValidDiscountByCode($code, $id)
    {
        return Discount::query()
            ->where("code", $code)
            ->where(function ($query) use ($id) {
                return $query->whereHas("courses", function ($query) use ($id) {
                    return $query->where("id", $id);
                })->orWhereDoesntHave("courses");
            })
            ->first();
    }
}
