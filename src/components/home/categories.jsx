import CategoryCard from "../categoryCard";

export default function Categories() {
    return (
        <section className="w-full px-3">
            <div className="w-full max-w-[1200px] mx-auto py-10">
                <div className="space-y-4">
                    <h2 className="text-4xl font-bold capitalize">
                        Buscar por{" "}
                        <span className="text-purple-700">categoría</span>
                    </h2>
                    <div className="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-5">
                        <CategoryCard name="Moda" image="/images/categories/moda.png" />
                        <CategoryCard name="Comida" image="/images/categories/comida.png" />
                        <CategoryCard name="tecnologia" image="/images/categories/tecnologia.png" />
                        <CategoryCard name="otros" image="/images/categories/otros.png" />
                    </div>
                </div>
            </div>
        </section>
    );
}
