@extends('layouts.main')

@section('content')
    <div class="container m-t-40">
        <ul class="card-list">
            <li class="card big">
                <a href="#">
                    <div class="card-header">
                        <div class="card-image" style="background-image: url({{ asset('images/events.jpg') }})"></div>
                        <div class="card-header-info">
                            <icon icon="{{ config('icons.event') }}"></icon>
                            <h1>{{ trans('action.find_event') }}</h1>
                        </div>
                    </div>
                </a>
            </li>
            @if($loggedUser)
                <li class="card">
                    <a href="#">
                        <div class="card-header">
                            <div class="card-image"
                                 style="background-image: url({{ $loggedUser->getAvatarLink() }})"></div>
                            <div class="card-header-info">
                                <icon icon="{{ config('icons.user') }}"></icon>
                                <h1>{{ $loggedUser->getDisplayName() }}</h1>
                            </div>
                        </div>
                    </a>
                </li>
            @else
                <li class="card">
                    <a href="{{ route('login') }}">
                        <div class="card-header">
                            <div class="card-image"
                                 style="background-image: url({{ asset('images/login.jpg') }})"></div>
                            <div class="card-header-info">
                                <icon icon="{{ config('icons.user') }}"></icon>
                                <h1>{{ trans('action.login') }}</h1>
                            </div>
                        </div>
                    </a>
                </li>
            @endif
            <li class="card">
                <a href="{{ route('login') }}">
                    <div class="card-header">
                        <div class="card-image"
                             style="background-image: url({{ asset('images/statistics.jpg') }})"></div>
                        <div class="card-header-info">
                            <icon icon="{{ config('icons.statistics') }}"></icon>
                            <h1>{{ trans('label.statistics') }}</h1>
                        </div>
                    </div>
                </a>
            </li>

            <li class="card big-width">
                <a href="#">
                    <div class="card-header">
                        <div class="card-image" style="background-image: url({{ asset('images/club.jpg') }})"></div>
                        <div class="card-header-info">
                            <icon icon="{{ config('icons.club') }}"></icon>
                            <h1>{{ trans('label.clubs') }}</h1>
                        </div>
                    </div>
                </a>
            </li>

        </ul>


        <ul class="card-list">

            <li class="card big-height">
                <a href="/topics/excel/">

                    <div class="card-header"
                         style="background-image: url(https://udemy-images.udemy.com/course/480x270/362328_91f3_10.jpg)">

                    </div>
                    <div class="card-content">
                        <h4 class="title">
                            AWS Certified Solutions Architect - Associate 2017
                        </h4>
                        <span class="subtitle">
                            Von Ryan Kroonenburg
                        </span>
                        <ul class="info-list">
                            <li>
                                <icon icon="{{ config('icons.event') }}"></icon>
                                <span>blas</span>
                            </li>
                            <li>
                                <icon icon="{{ config('icons.event') }}"></icon>
                                <span>blas</span>
                            </li>
                            <li>
                                <icon icon="{{ config('icons.user') }}"></icon>
                                <span>92.4K Eingeschrieben</span>
                            </li>
                        </ul>
                        <div class="card-extra">
                            <span>ab</span>
                            <span class="price">15 €</span>

                        </div>
                    </div>
                </a>
            </li>


            <li class="card">
                <a href="/3d-animation-basics-to-full-body-and-creature-mechanics/" class="fxdc">
            <span class="course-thumb">
                <img src="https://udemy-images.udemy.com/course/480x270/178102_5452_3.jpg"
                     alt="3D Animation: Basics To Full Body and Creature Mechanics">
            </span>

                    <span class="card-header-info fx fxdc">
                <span class="title">
                    3D Animation: Basics To Full Body and Creature Mechanics
                </span>


<span class="by fx">
    Von Charlie Grubel
</span>


                <span class="card-details fxac">


<i class="udi udi-users stud-icon"></i>
<span class="stud-count fx">
    334 Eingeschrieben
</span>




                        <span class="card__price">15 €</span>

                    <span class="card__price--old">
                        50 €
                    </span>
                </span>
            </span>
                </a>
            </li>


            <li class="card">
                <a href="/complete-ios-10-developer-course/" class="fxdc">
            <span class="course-thumb">
                <img src="https://udemy-images.udemy.com/course/480x270/895786_7b4b_2.jpg"
                     alt="The Complete iOS 10 Developer Course - Build 21 Apps">
            </span>

                    <span class="card-header-info fx fxdc">
                <span class="title">
                    The Complete iOS 10 Developer Course - Build 21 Apps
                </span>


<span class="by fx">
    Von Rob Percival
</span>


                <span class="card-details fxac">


<i class="udi udi-users stud-icon"></i>
<span class="stud-count fx">
    40.7K Eingeschrieben
</span>




                        <span class="card__price">15 €</span>

                    <span class="card__price--old">
                        200 €
                    </span>
                </span>
            </span>
                </a>
            </li>


            <li class="card">
                <a href="/photography-masterclass-your-complete-guide-to-photography/" class="fxdc">
            <span class="course-thumb">
                <img src="https://udemy-images.udemy.com/course/480x270/394968_538b_7.jpg"
                     alt="Photography Masterclass: Your Complete Guide to Photography">
            </span>

                    <span class="card-header-info fx fxdc">
                <span class="title">
                    Photography Masterclass: Your Complete Guide to Photography
                </span>


<span class="by fx">
    Von Phil Ebiner und 1 weitere
</span>


                <span class="card-details fxac">


<i class="udi udi-users stud-icon"></i>
<span class="stud-count fx">
    64.2K Eingeschrieben
</span>




                        <span class="card__price">15 €</span>

                    <span class="card__price--old">
                        200 €
                    </span>
                </span>
            </span>
                </a>
            </li>


            <li class="card">
                <a href="/body-language-for-entrepreneurs/" class="fxdc">
            <span class="course-thumb">
                <img src="https://udemy-images.udemy.com/course/480x270/84792_604a_13.jpg"
                     alt="Body Language for Entrepreneurs">
            </span>

                    <span class="card-header-info fx fxdc">
                <span class="title">
                    Body Language for Entrepreneurs
                </span>


<span class="by fx">
    Von Vanessa Van Edwards und 1 weitere
</span>


                <span class="card-details fxac">


<i class="udi udi-users stud-icon"></i>
<span class="stud-count fx">
    20.2K Eingeschrieben
</span>




                        <span class="card__price">15 €</span>

                    <span class="card__price--old">
                        200 €
                    </span>
                </span>
            </span>
                </a>
            </li>


            <li class="card">
                <a href="/amcourse/" class="fxdc">
            <span class="course-thumb">
                <img src="https://udemy-images.udemy.com/course/480x270/320490_d2e2_4.jpg"
                     alt="Affiliate Marketing - A Beginner's Guide to Earning Online">
            </span>

                    <span class="card-header-info fx fxdc">
                <span class="title">
                    Affiliate Marketing - A Beginner's Guide to Earning Online
                </span>


<span class="by fx">
    Von Lisa Irby
</span>


                <span class="card-details fxac">


<i class="udi udi-users stud-icon"></i>
<span class="stud-count fx">
    5K Eingeschrieben
</span>




                    <span class="card__price">
                        95 €
                    </span>
                </span>
            </span>
                </a>
            </li>


            <li class="card">
                <a href="/the-ultimate-python-programming-course/" class="fxdc">
            <span class="course-thumb">
                <img src="https://udemy-images.udemy.com/course/480x270/21323_192f_10.jpg"
                     alt="The Ultimate Python Programming Tutorial ">
            </span>

                    <span class="card-header-info fx fxdc">
                <span class="title">
                    The Ultimate Python Programming Tutorial
                </span>


<span class="by fx">
    Von Infinite Skills
</span>


                <span class="card-details fxac">


<i class="udi udi-users stud-icon"></i>
<span class="stud-count fx">
    22.3K Eingeschrieben
</span>




                        <span class="card__price">15 €</span>

                    <span class="card__price--old">
                        50 €
                    </span>
                </span>
            </span>
                </a>
            </li>


            <li class="card">
                <a href="/javaspring/" class="fxdc">
            <span class="course-thumb">
                <img src="https://udemy-images.udemy.com/course/480x270/65830_9629_3.jpg"
                     alt="The Java Spring Tutorial: Learn Java's Popular Web Framework">
            </span>

                    <span class="card-header-info fx fxdc">
                <span class="title">
                    The Java Spring Tutorial: Learn Java's Popular Web Framework
                </span>


<span class="by fx">
    Von John Purcell
</span>


                <span class="card-details fxac">


<i class="udi udi-users stud-icon"></i>
<span class="stud-count fx">
    22.8K Eingeschrieben
</span>




                        <span class="card__price">15 €</span>

                    <span class="card__price--old">
                        35 €
                    </span>
                </span>
            </span>
                </a>
            </li>


            <li class="card">
                <a href="/advanced-excel/" class="fxdc">
            <span class="course-thumb">
                <img src="https://udemy-images.udemy.com/course/480x270/9385_55cb_14.jpg"
                     alt="Microsoft Excel 2010: Advanced Training">
            </span>

                    <span class="card-header-info fx fxdc">
                <span class="title">
                    Microsoft Excel 2010: Advanced Training
                </span>


<span class="by fx">
    Von Infinite Skills
</span>


                <span class="card-details fxac">


<i class="udi udi-users stud-icon"></i>
<span class="stud-count fx">
    72.9K Eingeschrieben
</span>




                        <span class="card__price">15 €</span>

                    <span class="card__price--old">
                        50 €
                    </span>
                </span>
            </span>
                </a>
            </li>


            <li class="card">
                <a href="/elizabeth-gilberts-creativity-workshop/" class="fxdc">
            <span class="course-thumb">
                <img src="https://udemy-images.udemy.com/course/480x270/806626_f5c3_3.jpg"
                     alt="Acumen Presents: Elizabeth Gilbert's Creativity Workshop">
            </span>

                    <span class="card-header-info fx fxdc">
                <span class="title">
                    Acumen Presents: Elizabeth Gilbert's Creativity Workshop
                </span>


<span class="by fx">
    Von +Acumen Courses und 1 weitere
</span>


                <span class="card-details fxac">


<i class="udi udi-users stud-icon"></i>
<span class="stud-count fx">
    13.5K Eingeschrieben
</span>




                    <span class="card__price">
                        100 €
                    </span>
                </span>
            </span>
                </a>
            </li>


            <li class="card">
                <a href="/learn-html5-programming-from-scratch/" class="fxdc">
            <span class="course-thumb">
                <img src="https://udemy-images.udemy.com/course/480x270/41295_dd3f_6.jpg"
                     alt="Learn HTML5 Programming From Scratch    ">
            </span>

                    <span class="card-header-info fx fxdc">
                <span class="title">
                    Learn HTML5 Programming From Scratch
                </span>


<span class="by fx">
    Von Eduonix Learning Solutions und 1 weitere
</span>


                <span class="card-details fxac">


<i class="udi udi-users stud-icon"></i>
<span class="stud-count fx">
    250.2K Eingeschrieben
</span>




                    <span class="card__price">
                        Kostenlos
                    </span>
                </span>
            </span>
                </a>
            </li>


            <li class="card">
                <a href="/java-tutorial/" class="fxdc">
            <span class="course-thumb">
                <img src="https://udemy-images.udemy.com/course/480x270/24823_963e_12.jpg"
                     alt="Java Tutorial for Complete Beginners">
            </span>

                    <span class="card-header-info fx fxdc">
                <span class="title">
                    Java Tutorial for Complete Beginners
                </span>


<span class="by fx">
    Von John Purcell
</span>


                <span class="card-details fxac">


<i class="udi udi-users stud-icon"></i>
<span class="stud-count fx">
    658.5K Eingeschrieben
</span>




                    <span class="card__price">
                        Kostenlos
                    </span>
                </span>
            </span>
                </a>
            </li>


            <li class="card">
                <a href="/plc-programming-from-scratch/" class="fxdc">
            <span class="course-thumb">
                <img src="https://udemy-images.udemy.com/course/480x270/118042_251a_11.jpg"
                     alt="PLC Programming From Scratch (PLC I)">
            </span>

                    <span class="card-header-info fx fxdc">
                <span class="title">
                    PLC Programming From Scratch (PLC I)
                </span>


<span class="by fx">
    Von Paul Lynn
</span>


                <span class="card-details fxac">


<i class="udi udi-users stud-icon"></i>
<span class="stud-count fx">
    8.3K Eingeschrieben
</span>




                        <span class="card__price">15 €</span>

                    <span class="card__price--old">
                        100 €
                    </span>
                </span>
            </span>
                </a>
            </li>


        </ul>


        <a href="/courses/" class="explore-all-btn" data-purpose="browse-courses">
            Kurse durchstöbern
        </a>

    </div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        new VueModel({
            el: '#app'
        });
    });
</script>
@endpush
