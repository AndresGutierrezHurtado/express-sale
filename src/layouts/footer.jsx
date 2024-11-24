import { Link } from "react-router-dom";

export default function Footer() {
    return (
        <footer className="w-full px-3">
            <section className="w-full max-w-[1200px] mx-auto py-3">
                <article className="w-full bg-gray-200/50 rounded-full px-5 py-2 font-bold text-gray-600/90 backdrop-blur">
                    <div className="flex flex-col md:flex-row justify-between items-center">
                        <h3>&copy; Express Sale, 2024.</h3>
                        <Link
                            to="mailto:epxresssale.exsl@gmail.com"
                            className="underline underline-offset-2"
                        >
                            Contáctanos
                        </Link>
                    </div>
                </article>
            </section>
        </footer>
    );
}
