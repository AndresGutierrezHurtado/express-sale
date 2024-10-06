import React, { useEffect, useState } from "react";

// Hooks
import { useFetchData } from "./hooks/useFetchData";

export default function App() {
    const [users, setUsers] = useState([]);
    const [products, setProducts] = useState([]);
    const [orders, setOrders] = useState([]);

    useEffect(() => {
        (async () => {
            setUsers(await useFetchData("/api/users"));
            setProducts(await useFetchData("/api/products"));
            setOrders(await useFetchData("/api/orders"));
        })();
    }, []);
    console.log(users, products, orders);

    return (
        <div className="text-3xl font-bold">
            <h1>Express Sale</h1>
        </div>
    );
}
