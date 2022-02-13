<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Video;
use Illuminate\Validation\Rule;

class VideoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'storyboard_id' => [
//                'required',
//                'exists:story_boards,storyboard_id'
//            ],
            'video_type' => [
                'required',
                $this->videoTypes()
            ],
            'height' => [
                'required',
                'numeric',
                'between:1,1920'
            ],
            'data' => [
                'required',
                'array'
            ],
        ];
    }

    public function videoTypes()
    {
        return Rule::in(Video::TYPES);
    }
}
