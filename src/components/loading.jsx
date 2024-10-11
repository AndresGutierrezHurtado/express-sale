export default function Loading() {
    return (
        <main className="fixed top-0 left-0 flex items-center justify-center w-full h-screen bg-purple-800/90 z-[9999]">
            <div className="flex flex-col items-center justify-center text-white space-y-4">
                <div>
                    <span className="loading loading-infinity w-[200px]"></span>
                    <h2 className="text-5xl font-extrabold">Cargando ...</h2>
                </div>
                <p>Espera pacientemente mientras carga tu plataforma de compras.</p>
            </div>
        </main>
    )
}