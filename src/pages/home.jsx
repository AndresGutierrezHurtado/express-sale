import { Link } from "react-router-dom";

// Components
import { CategoryCard } from "@components/categoryCard.jsx";
import { ArrowRight } from "@components/icons.jsx";

export default function Home() {
    return (
        <>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="flex flex-col md:flex-row items-center gap-5[&>*]:w-full  md:[&>*]:w-1/2">
                        <figure>
                            <img
                                src="/images/hero-image.png"
                                alt="Imagen presentación Express Sale"
                            />
                        </figure>
                        <div className="space-y-4">
                            <div className="space-y-2">
                                <h1 className="text-3xl md:text-6xl font-extrabold">
                                    ¡Bienvenidos a Express Sale!
                                </h1>
                                <p className="text-xl text-pretty">
                                    Acá podrás comprar los{" "}
                                    <span className="text-purple-700 font-bold">
                                        Mejores productos
                                    </span>{" "}
                                    de las tiendas de barrio de bogotá.
                                </p>
                            </div>
                            <Link
                                to="/products"
                                className="btn btn-sm btn-primary rounded-full h-auto min-h-auto py-3 px-10"
                            >
                                Ver productos
                                <ArrowRight />
                            </Link>
                        </div>
                    </div>
                </div>
            </section>

            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="space-y-4">
                        <h2 className="text-4xl font-bold capitalize">
                            Buscar por{" "}
                            <span className="text-purple-700">categoría</span>
                        </h2>
                        <div className="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-5">
                            <CategoryCard
                                name="Moda"
                                image="/images/categories/moda.png"
                            />
                            <CategoryCard
                                name="Comida"
                                image="/images/categories/comida.png"
                            />
                            <CategoryCard
                                name="tecnologia"
                                image="/images/categories/tecnologia.png"
                            />
                            <CategoryCard
                                name="otros"
                                image="/images/categories/otros.png"
                            />
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}
