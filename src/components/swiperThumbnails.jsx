import React, { useState } from "react";

import { Swiper, SwiperSlide } from "swiper/react";
import { FreeMode, Navigation, Thumbs } from "swiper/modules";

import "swiper/css";
import "swiper/css/free-mode";
import "swiper/css/navigation";
import "swiper/css/thumbs";

export default function SwiperThumbnails({ images = [], size = 300 }) {
    const [thumbsSwiper, setThumbsSwiper] = useState(null);
    const [current, setCurrent] = useState(0);

    return (
        <figure
            className="flex items-center justify-center gap-5 w-full"
            style={{ maxWidth: `${size}px`, height: `${size - 120}px` }}
        >
            <div className="w-fit relative">
                <div className="badge badge-sm absolute top-2 right-2 z-10">
                    {current + 1 || 1} / {images.length}
                </div>

                <Swiper
                    style={{
                        "--swiper-navigation-color": "#4e99d3",
                        "--swiper-pagination-color": "#4e99d3",
                        maxWidth: `${size - 120}px`,
                    }}
                    spaceBetween={10}
                    navigation={true}
                    thumbs={{ swiper: thumbsSwiper }}
                    modules={[FreeMode, Navigation, Thumbs]}
                    onSlideChange={(swiper) => setCurrent(swiper.activeIndex)}
                    className="mySwiper2 rounded w-full"
                >
                    {images.map((image, index) => (
                        <SwiperSlide
                            key={image.id}
                            className="flex items-center justify-center h-[auto_!important]"
                        >
                            <img
                                src={image.url}
                                alt={image.alt}
                                className="w-full h-full object-contain"
                            />
                        </SwiperSlide>
                    ))}
                </Swiper>
            </div>
            <div className="w-[100px] hidden md:block h-full">
                <Swiper
                    onSwiper={setThumbsSwiper}
                    spaceBetween={10}
                    slidesPerView={3}
                    watchSlidesProgress={true}
                    modules={[FreeMode, Navigation, Thumbs]}
                    className="mySwiper w-full h-full"
                    style={{ height: `${size - 120}px` }}
                    direction="vertical"
                >
                    {images.map((image) => (
                        <SwiperSlide
                            key={image.id}
                            className="aspect-square w-[100%_!important] rounded h-[auto_!important]"
                        >
                            <img
                                src={image.url}
                                alt={image.alt}
                                className="w-full h-full object-contain"
                            />
                        </SwiperSlide>
                    ))}
                </Swiper>
            </div>
        </figure>
    );
}
