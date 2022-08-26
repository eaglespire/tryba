@if(count(getStoreBlogActive(getStorefrontOwner($store->user_id)->storefront()->id, getLayout($store->id)->blog_limit ?? 0)) > 1)
<!-- blog area start here -->
<section class="tp-blog-area pt-90 pb-85">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-wrapper text-center mb-55 wow fadeInUp" data-wow-delay=".2s">
                    <h5 class="tp-section-subtitle common-yellow-shape mb-20">{{ getLayout($store->id)->blog_body ?? NULL }}</h5>
                    <h2 class="tp-section-title mb-25">{{ getLayout($store->id)->blog_title ?? NULL }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach(getStoreBlogActive(getStorefrontOwner($store->user_id)->storefront()->id, getLayout($store->id)->blog_limit ?? 0) as $k=>$val)
                <div class="col-lg-4 col-md-6">
                    <div class="tp-blog mb-30 wow fadeInUp" data-wow-delay=".4s">
                        <div class="tp-blog-img mb-25">
                            <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}">
                                <img src="{{ asset('asset/profile/'.$val->image) }}" class="img-fluid" alt="img not found">
                            </a>
                            <span class="tp-blog-badge">Recent News</span>
                        </div>
                        <div class="tp-blog-text">
                            <div class="tp-blog-meta mb-10">
                                <ul>1628001770
                                    <li><a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}">// {{ date("M, d Y", strtotime($val->created_at)) }}</a></li>
                                </ul>
                            </div>
                            <h4 class="tp-blog-title mb-20"><a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}">{{$val->title}}</a></h4>
                            <div class="tp-blog-link">
                                <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}"><i class="flaticon-enter"></i> Continue Reading</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- blog area end here -->
@endif
