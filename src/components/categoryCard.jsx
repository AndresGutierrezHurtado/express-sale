export default function CategoryCard({ name, image }) {
    return (
        <div className="card bg-base-100 w-full shadow-xl">
            <div className="card-body items-center text-center">
                <figure className="size-[100px]">
                    <img
                        src={image}
                        alt={`Imagen de la categoría ${name}`}
                        className="object-contain h-full w-full"
                    />
                </figure>
                <h2 className="card-title">{name}</h2>
            </div>
        </div>
    );
}
