import { ArrowRight } from "../icons.jsx";
import { Link } from "react-router-dom";

export default function HeroIndex() {
    return (
        <section className="w-full px-3">
            <div className="w-full max-w-[1200px] mx-auto py-10">
                <div className="flex flex-col md:flex-row items-center gap-5[&>*]:w-full  md:[&>*]:w-1/2">
                    <figure>
                        <img src="/images/hero-image.png" alt="" />
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
    );
}
