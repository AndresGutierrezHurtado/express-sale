import { Link } from "react-router-dom";

export function CategoryCard({ name, image, link }) {
    return (
        <Link to={link} className="card bg-white w-full shadow-xl hover:scale-105 duration-300">
            <div className="card-body items-center text-center">
                <figure className="size-[140px]">
                    <img
                        src={image}
                        alt={`Imagen de la categoría ${name}`}
                        className="object-contain h-full w-full"
                    />
                </figure>
                <h2 className="text-2xl font-semibold tracking-tight">{name}</h2>
            </div>
        </Link>
    );
}
