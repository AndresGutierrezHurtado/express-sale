import { Link } from "react-router-dom";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Pagination, EffectCoverflow } from "swiper/modules";
import VanillaTilt from "vanilla-tilt";

// Components
import { ArrowRightIcon, RegisterIcon } from "@components/icons.jsx";
import { VerticalProductCard } from "@components/verticalProductcard";
import ContentLoading from "@components/contentLoading.jsx";

// Hooks
import { usePaginateData, usePostData } from "@hooks/useFetchData.js";
import { useValidateform } from "@hooks/useValidateForm.js";
import { useEffect } from "react";

import "swiper/css";
import "swiper/css/effect-coverflow";
import "swiper/css/pagination";

export default function Home() {
    const {
        loading: loadingProducts,
        data: products,
        reload: reloadProducts,
    } = usePaginateData("/products");

    const handleContactFormSubmit = async (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "contact-form");
        if (!validation.success) return;

        const response = await usePostData("/feedback", data);
        if (!response.success) return;

        event.target.reset();
    };

    useEffect(() => {
        VanillaTilt.init(document.querySelectorAll(".tilt"), {
            max: 10,
            scale: 1.04,
            speed: 400,
            transition: true,
            glare: true,
            "max-glare": 0.3,
            reverse: true,
        });
    }, [products]);

    if (loadingProducts) return <ContentLoading />;

    return (
        <>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="flex flex-col md:flex-row items-center gap-10">
                        <figure className="w-full md:w-2/5">
                            <img
                                src="/images/hero-image.png"
                                alt="Imagen presentación Express Sale"
                            />
                        </figure>
                        <div className="w-full md:w-3/5 space-y-5">
                            <div className="space-y-2">
                                <div className="bg-base-300 border border-primary px-3 py-1.5 rounded w-fit opacity-80">
                                    <span className="text-primary font-semibold">
                                        La mejor calidad
                                    </span>
                                </div>
                                <h1 className="text-3xl md:text-6xl font-extrabold">
                                    ¡Bienvenidos a <br />
                                    Express Sale!
                                </h1>
                                <p className="text-xl text-pretty">
                                    Acá podrás comprar los{" "}
                                    <span className="text-primary font-bold">
                                        Mejores productos
                                    </span>{" "}
                                    de las tiendas de barrio de bogotá.
                                </p>
                            </div>
                            <Link
                                to="/products"
                                className="btn btn-sm btn-primary btn-shadow-none text-base rounded-full h-auto min-h-auto py-2 px-10"
                            >
                                <span>Ver productos</span>
                                <ArrowRightIcon />
                            </Link>
                        </div>
                    </div>
                </div>
            </section>

            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="space-y-4">
                        <h2 className="text-4xl font-bold capitalize">
                            Buscar por <span className="text-primary">categoría</span>
                        </h2>
                        <div className="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-12">
                            {[
                                {
                                    name: "Moda",
                                    image: "/images/categories/moda.jpg",
                                    link: "/products?category_id=1",
                                },
                                {
                                    name: "Comida",
                                    image: "/images/categories/comida.jpg",
                                    link: "/products?category_id=2",
                                },
                                {
                                    name: "Tecnología",
                                    image: "/images/categories/tecnologia.jpg",
                                    link: "/products?category_id=3",
                                },
                                {
                                    name: "Otros",
                                    image: "/images/categories/otros.jpg",
                                    link: "/products?category_id=4",
                                },
                            ].map(({ name, image, link }, index) => (
                                <Link
                                    to={link}
                                    key={index}
                                    className="bg-white/80 rounded-lg border-base-300/50 border shadow-lg cursor-pointer hover:scale-[1.03] duration-300"
                                >
                                    <div className="card-body items-center text-center">
                                        <figure className="size-[140px]">
                                            <img
                                                src={image}
                                                alt={`Imagen de la categoría ${name}`}
                                                className="object-contain h-full w-full"
                                            />
                                        </figure>
                                        <h2 className="text-2xl font-semibold tracking-tight">
                                            {name}
                                        </h2>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    </div>
                </div>
            </section>

            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="space-y-4">
                        <h2 className="text-4xl font-bold capitalize">
                            Los productos <span className="text-primary">más Destacados</span>
                        </h2>
                        <Swiper
                            modules={[Navigation, Pagination]}
                            spaceBetween={50}
                            slidesPerView={1}
                            navigation
                            pagination={{
                                clickable: true,
                                renderBullet: function (index, className) {
                                    return `<span class="${className}"></span>`;
                                },
                            }}
                            breakpoints={{
                                640: {
                                    slidesPerView: 1,
                                    spaceBetween: 20,
                                },
                                768: {
                                    slidesPerView: 2,
                                    spaceBetween: 20,
                                },
                                1024: {
                                    slidesPerView: 3,
                                    spaceBetween: 20,
                                },
                            }}
                            className="py-10"
                        >
                            {products.map((product) => (
                                <SwiperSlide
                                    key={product.product_id}
                                    className="flex items-center justify-center mb-10"
                                >
                                    <VerticalProductCard
                                        product={product}
                                        reloadProducts={reloadProducts}
                                    />
                                </SwiperSlide>
                            ))}
                        </Swiper>
                        <div className="flex w-full justify-center">
                            <Link
                                to="/products"
                                className="btn btn-sm btn-primary btn-shadow-none text-base rounded-lg h-auto min-h-auto py-2 px-10"
                            >
                                Ver todos los productos
                                <ArrowRightIcon />
                            </Link>
                        </div>
                    </div>
                </div>
            </section>

            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="flex flex-col items-center justify-center gap-4 text-center">
                        <figure className="w-64 aspect-square drop-shadow-[0_15px_35px_rgb(126_34_206)]">
                            <img
                                src="/logo.png"
                                alt="Logo Express Sale"
                                className="object-contain h-full w-full"
                            />
                        </figure>
                        <div className="space-y-2">
                            <h2 className="text-4xl font-bold capitalize">
                                ¿Quiénes <span className="text-primary">Somos?</span>
                            </h2>
                            <div className="text-xl max-w-4xl space-y-2">
                                <p className="text-balance">
                                    Express Sale ha sido creado por cuatro aprendices SENA:{" "}
                                    <span className="font-bold text-primary italic">
                                        Andrés Gutiérrez, Juan Sebastián Bernal, Jaider Harley
                                        Rondón y David Fernando Díaz.
                                    </span>{" "}
                                    Juntos, han planeado y desarrollado esta herramienta para
                                    facilitar la gestión de inventarios, la venta de productos y la
                                    conexión entre comerciantes y clientes, ofreciendo una
                                    plataforma moderna y accesible para todos.
                                </p>
                                <p className="text-balance">
                                    En Express Sale, nuestra misión es{" "}
                                    <span className="font-bold text-primary">
                                        llevar las tiendas de barrio al mundo digital
                                    </span>
                                    , ayudándolas a expandir su alcance y competir en el mercado
                                    actual.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="space-y-5">
                        <h2 className="text-4xl font-bold capitalize">
                            ¡Queremos <span className="text-primary">Escucharte!</span>
                        </h2>
                        <article className="bg-base-200/80 p-7 rounded-lg shadow-xl border border-base-300 space-y-5">
                            <p className="text-xl text-base-content/80">
                                Si quieres contarnos tu opinión o tienes alguna queja sobre nuestro
                                sistema de información puedes enviarnoslo por aquí:
                            </p>
                            <form onSubmit={handleContactFormSubmit}>
                                <div className="w-full flex flex-col md:flex-row gap-8">
                                    <fieldset className="fieldset w-full">
                                        <label className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                                            Correo Electrónico:
                                        </label>
                                        <input
                                            placeholder="Ingresa tu correo"
                                            className="w-full input input-bordered focus:outline-0 focus:border-primary"
                                            name="user_email"
                                        />
                                    </fieldset>
                                    <fieldset className="fieldset w-full">
                                        <label className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                                            Nombre Completo:
                                        </label>
                                        <input
                                            placeholder="Ingresa tu nombre"
                                            className="w-full input input-bordered focus:outline-0 focus:border-primary"
                                            name="user_name"
                                        />
                                    </fieldset>
                                </div>
                                <fieldset className="fieldset w-full">
                                    <label className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                                        Asunto:
                                    </label>
                                    <input
                                        placeholder="Ingresa el tema de tu mensaje"
                                        className="w-full input input-bordered focus:outline-0 focus:border-primary"
                                        name="email_subject"
                                    />
                                </fieldset>
                                <fieldset className="fieldset w-full">
                                    <label className="fieldste-label text-sm after:content-['*'] after:text-red-500">
                                        Mensaje:
                                    </label>
                                    <textarea
                                        placeholder="Ingresa tu mensaje/opinión aquí"
                                        className="w-full textarea textarea-bordered focus:outline-0 focus:border-primary resize-none"
                                        name="email_message"
                                    ></textarea>
                                </fieldset>
                                <div className="form-control w-full mt-5">
                                    <button className="btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 w-full">
                                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                            <RegisterIcon size={17} />
                                        </span>
                                        Enviar mensaje
                                    </button>
                                </div>
                            </form>
                        </article>
                    </div>
                </div>
            </section>
        </>
    );
}
