export default function ContentLoading() {
    return (
        <section className="w-full px-3">
            <section className="w-full max-w-[1200px] mx-auto">
                <div className="flex flex-col items-center justify-center text-gray-600 leading-none py-12">
                    <span className="loading w-[110px]"></span>
                    <h4 className="text-xl font-extrabold">
                        Cargando el contenido...
                    </h4>
                    <p className="text-lg text-gray-400">
                        Espera pacientemente porque esto puede tardar
                    </p>
                </div>
            </section>
        </section>
    );
}
