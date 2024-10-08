import { FaArrowRight as ArrowRight } from "react-icons/fa6";
import { Link } from "react-router-dom";

export default function Home() {
    return (
        <>
            <section className="w-full">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="flex items-center gap-10 [&>*]:w-1/2">
                        <figure>
                            <img src="/images/hero-image.png" alt="" />
                        </figure>
                        <div className="space-y-4">
                            <div className="space-y-2">
                                <h1 className="text-6xl font-extrabold">
                                    ¡Bienvenidos a Express Sale!
                                </h1>
                                <p className="text-xl">Acá podrás comprar los <span className="text-purple-700 font-bold">Mejores productos</span> de las tiendas de barrio de bogotá</p>
                            </div>
                            <Link to="/products" className="btn btn-sm btn-primary rounded-full h-auto min-h-auto py-3 px-10">
                                Ver productos
                                <ArrowRight />
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}