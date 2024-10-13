export default function Pagination({data, updateParam, searchParams}) {
    return (
        <>
            <p className="text-sm font-bold text-gray-600/90">
                Viendo {((searchParams.get("page") || 1) - 1) * 5 + 1} -{" "}
                {((searchParams.get("page") || 1) - 1) * 5 +
                    data.rows.length}{" "}
                de {data.count} resultados
            </p>
            <div className="flex gap-2">
                <button
                    className="btn btn-sm"
                    onClick={() =>
                        updateParam(
                            "page",
                            parseInt(searchParams.get("page") || 1) - 1
                        )
                    }
                    disabled={(searchParams.get("page") || 1) == 1}
                >
                    Prev
                </button>
                <button
                    className="btn btn-sm"
                    onClick={() =>
                        updateParam(
                            "page",
                            parseInt(searchParams.get("page") || 1) + 1
                        )
                    }
                    disabled={
                        parseInt(searchParams.get("page") || 1) >=
                        Math.ceil(data.count / 5)
                    }
                >
                    Next
                </button>
            </div>
        </>
    );
}
