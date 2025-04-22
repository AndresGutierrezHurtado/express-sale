import { Link } from "react-router-dom";

export default function Footer() {
    return (
        <footer className="w-full px-3">
            <section className="w-full max-w-[1200px] mx-auto py-3">
                <article className="w-full bg-base-200/50 border border-base-300/60 rounded-full px-5 py-2 font-bold backdrop-blur">
                    <div className="flex flex-col md:flex-row justify-between items-center text-base-content/60">
                        <h3>&copy; Express Sale, 2024.</h3>
                        <Link
                            to="mailto:epxresssale.exsl@gmail.com"
                            className="hover:underline underline-offset-2"
                        >
                            Contáctanos
                        </Link>
                    </div>
                </article>
            </section>
        </footer>
    );
}
