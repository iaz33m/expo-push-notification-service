<?php
namespace App\Services;

use App\User;
use App\UserDetail;
use App\Helpers\FileHelper;
use Intervention\Image\Facades\Image;


class UserService extends Service
{

    public static $RULES = [
        'name' => 'required',
        'email' => 'required|email'
    ];

    public static $CREATE_RULES = [
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ];

    public static function getCreateRules()
    {
        return array_merge(self::$RULES, self::$CREATE_RULES);
    }

    public static function getEditRules($data, $user)
    {

        $editRules = [];

        if ($user->email != $data['email']) {
            $editRules['email'] = 'required|unique:users';
        }

        return array_merge(self::$RULES, $editRules);
    }

    public function all()
    {
        $qb = $this->getQB();
        return $qb->get();
    }

    public function allWithPagination()
    {
        $qb = $this->getQB();
        return $qb->paginate();
    }

    public function find($where)
    {

        // $model = User::where($where)->with('userDetail')->first();

        $model = User::where($where)->first();

        if (!$model) {
            abort(400, 'User Does not exists');
        }

        return $model;
    }

    public function create($data)
    {

        $this->validateOrAbort($data, self::getCreateRules());

        $user = User::create($this->getUserCreateEditInput($data));

        $data['user_id'] = $user->id;

        return $user;
    }

    public function update($id, $data)
    {

        $user = $this->find([['id', $id]]);

        $this->validateOrAbort($data, self::getEditRules($data, $user));

        $data['avatar'] = $this->getPathFromFile($data['avatar']);

        if ($data['avatar'] != null) {
            FileHelper::deleteFileIfNotDefault($user->avatar);
        } else {
            $data['avatar'] = $user->avatar;
        }

        $user->update($this->getUserCreateEditInput($data));

        $data['user_id'] = $user->id;

        // $user->userDetail->update($this->getUserDetailsInput($data));

        return $user;
    }

    public function getPathFromFile($avatar)
    {

        $path = null;

        if ($avatar) {

            $img = Image::make($avatar)->resize(300, 300);

            $result = FileHelper::getAndCreatePath($img->filename, 'avatar');

            $extension = substr($img->mime, strpos($img->mime, '/') + 1);

            $result['name'] = $result['name'] . str_random(15) . '.' . $extension;

            $path = $result['path'] . "/" . $result['name'];

            $img->save($path, 60);
        }

        return $path;
    }

    public function delete($where)
    {
        return User::where($where)->delete();
    }

    public function getQB()
    {
        $qb = User::orderBy('updated_at', 'DESC');
        return $qb;
    }

    private function getUserCreateEditInput($data)
    {

        $input = [];

        if (isset($data['password'])) {
            $input['password'] = bcrypt($data['password']);
        }

        return array_merge($this->getUserInput($data), $input);
    }

    private function getUserInput($data)
    {
        return [
            'name' => $data['name'],
            'email' => $data['email']
        ];
    }
}
