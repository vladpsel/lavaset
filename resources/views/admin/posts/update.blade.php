@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div id="admin">
        <aside class="admin-aside">
            @include('admin.partials._admin-aside')
            <div class="admin-aside__bar">
                <form action="#" class="form-main mb-1">
                    <fieldset>
                        <input type="text" placeholder="Пошук">
                    </fieldset>
                </form>
                @if(count($items) < 1)
                    <p>Немає єлементів</p>
                @else
                    <ul class="aside-bar__list">
                        @foreach($items as $item)
                            <li>
                                <p class="mb-1">#{{ $item[0]->group . ': ' . $item[0]->title  }}</p>
                                <ul class="list">
                                    @foreach($item as $singleItem)
                                        <li>
                                            <a href="{{ route('admin.posts.single', $singleItem->id) }}" class="lang-item">{{ $singleItem->locale }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </aside>
        <div class="dashboard-panel">
            <form class="form-main" action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex f-between v-center">
                    <h1 class="title-main item mb-1">Оновити публікацію</h1>
                    <div class="btn-group item mb-1">
                        <a href="{{ route('admin.posts.single.delete', $post->group) }}" class="btn btn-main alert">Видалити</a>
                        <button type="submit" name="submit" class="btn btn-main primary">Оновити</button>
                    </div>
                </div>
                <div class="flex">
                    <div class="one-of-three">
                        <fieldset>
                            <label class="label">Заголовок</label>
                            <input type="text" name="title" value="{{ request()->input('title', $post->title) }}">
                            @error('title')
                            <p class="notice mb-1 full error"> {{ $message }} </p>
                            @enderror
                        </fieldset>

                        <fieldset>
                            <label class="label">Аліас</label>
                            <input type="text" name="alias" value="{{ request()->input('alias', $post->alias) }}" class="translit-input" required>
                            @error('alias')
                            <p class="notice mb-1 full error"> {{ $message }} </p>
                            @enderror
                        </fieldset>

                        <fieldset>
                            <label class="label">Зображення: <span class="notice">{{ $post->picture }}</span> </label>
                            @if(!empty($post->picture))
                                <button type="submit" name="remove_pic" value="picture" class="flex error mb-1">Видалити зображення</button>
                            @endif
                            <input type="file" name="picture">
                        </fieldset>

                        <div class="dropdown-select">
                            <fieldset>
                                <label class="label">Посилання</label>
                                <input type="text" name="link" value="{{ request()->input('link', old('link')) }}">
                                @error('link')
                                <p class="notice mb-1 full error"> {{ $message }} </p>
                                @enderror
                            </fieldset>
                            <ul class="dropdown-select__list">
                                @foreach($pages as $page)
                                    <li data-text="{{$page->title}}" data-link="{{ $page->alias }}">
                                        {{ $page->title }}
                                    </li>
                                @endforeach
                                @foreach($categories as $category)
                                    <li data-text="{{$category->title}}" data-link="/category/{{ $category->alias }}">
                                        {{ $category->title }}
                                    </li>
                                @endforeach
                                @foreach($products as $product)
                                    <li data-text="{{ $product->title }}" data-link="/product/{{ $product->alias }}">
                                        {{ $product->title }}
                                    </li>
                                @endforeach

                            </ul>
                        </div>

                        <fieldset>
                            <label class="label">Текст кнопки</label>
                            <input type="text" name="btn_title" value="{{ request()->input('btn_title', $post->btn_title) }}">
                            @error('btn_title')
                            <p class="notice mb-1 full error"> {{ $message }} </p>
                            @enderror
                        </fieldset>

                        <fieldset>
                            <label class="label">Порядковий номер</label>
                            <input type="number" name="sort_order" value="{{ request()->input('sort_order', $post->sort_order) }}" min="1">
                            @error('sort_order')
                            <p class="notice mb-1 full error"> {{ $message }} </p>
                            @enderror
                        </fieldset>

                        <fieldset>
                            <label class="label">Статус</label>
                            <select name="is_visible">
                                <option value="1" @if($post->is_visible == '1') selected @endif>На сайті</option>
                                <option value="0" @if($post->is_visible == '0') selected @endif>Приховано</option>
                            </select>
                            @error('sort_order')
                            <p class="notice mb-1 full error"> {{ $message }} </p>
                            @enderror
                        </fieldset>
                    </div>
                    <div class="two-of-three">
                        <fieldset>
                            <label class="label">Текст</label>
                            <textarea name="text" cols="30" rows="10">{{ request()->input('text', $post->text) }}</textarea>
                            @error('text')
                            <p class="notice mb-1 full error"> {{ $message }} </p>
                            @enderror
                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
