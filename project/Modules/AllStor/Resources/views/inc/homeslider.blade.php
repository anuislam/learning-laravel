@inject('media', 'App\mediaModel')
<div class="fr-slider-wrap">
    <div class="fr-slider">
        <ul class="slides">
            @php
            $sliders = '';
            if (function_exists('slider_get_slider')) {
                $sliders = slider_get_slider();
            }
            @endphp
            @if($sliders)
                @foreach($sliders as $slider)

                @php
                    $data_image = $media->get_image_src('slider_image', $slider['slider_image']);
                @endphp
                    <li>
                        <img src="{{ $data_image[0] }}" alt="">
                        <div class="fr-slider-cont">
                            <h3 style="text-transform: uppercase;">{{ $slider['slider_title'] }}</h3>
                            <p>{{ $slider['slider_content'] }}</p>
                            <p class="fr-slider-more-wrap">
                                <a class="fr-slider-more" href="{{ $slider['slider_url'] }}">{{ $slider['button_title'] }}</a>
                            </p>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>