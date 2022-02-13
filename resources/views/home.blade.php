@extends('layouts.app')

@section('content')
<div class="container">
    <video-modal
        v-if="showModal"
        :name="storyBoardName"
        :data="storyBoardData"
        @close="closeModal">
    </video-modal>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Videos') }}
                    <button type="button" class="btn btn-primary" title="Generate new video" @click="showGenerateVideoModal">+</button>
                </div>
                <div class="card-body">
                    <video-list-component
                        :videos="videos"
                        v-on:play-video="playEvent"
                    ></video-list-component>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div id="idm"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
