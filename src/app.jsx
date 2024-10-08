import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";

// Layouts
import AppLayout from "./layouts/appLayout";
import GuestLayout from "./layouts/guestLayout";
import Home from "./pages/home";
import Login from "./pages/auth/login";
import Register from "./pages/auth/register";

export default function App() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<AppLayout />}>
                    <Route index element={<Home />} />
                </Route>
                <Route path="/" element={<GuestLayout />}>
                    <Route path="login" element={<Login />} />
                    <Route path="register" element={<Register />} />
                </Route>
                <Route path="*" element={<h1>Not found</h1>} />
            </Routes>
        </BrowserRouter>
    );
}
