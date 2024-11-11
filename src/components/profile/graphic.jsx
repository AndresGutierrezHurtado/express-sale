import React from "react";

import { Line } from "react-chartjs-2";
import {
    Chart as ChartJS,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";

// Registra los componentes de chart.js
ChartJS.register(LineElement, CategoryScale, LinearScale, PointElement, Title, Tooltip, Legend);

export function DeliveryGraphic({ data, graphicData }) {
    const chartData = {
        labels: data.map((el) => el.monthToText),
        datasets: [
            {
                label: "Dinero recaudado",
                data: data.map((el) => el.money),
                backgroundColor: "rgba(53, 162, 235, 0.5)",
                borderColor: "rgba(53, 162, 235, 1)",
            },
            {
                label: "Numero de envios",
                data: data.map((el) => el.sales),
                backgroundColor: "rgba(255, 99, 132, 0.5)",
                borderColor: "rgba(255, 99, 132, 1)",
            },
        ],
    };

    if (graphicData == "money") chartData.datasets.pop();
    if (graphicData == "sales") chartData.datasets.shift();

    const chartOptions = {
        responsive: true,
        plugins: {
            legend: {
                position: "top",
            },
            title: {
                display: true,
                text: `Estadísticas de envíos del año ${data[0].year}`,
            },
        },
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    };

    return <Line data={chartData} options={chartOptions} />;
}

export function SellerGraphic({ data, graphicData }) {
    const chartData = {
        labels: data.map((el) => el.monthToText),
        datasets: [
            {
                label: "Dinero recaudado",
                data: data.map((el) => el.money),
                backgroundColor: "rgba(53, 162, 235, 0.5)",
                borderColor: "rgba(53, 162, 235, 1)",
            },
            {
                label: "Numero de productos vendidos",
                data: data.map((el) => el.sales),
                backgroundColor: "rgba(255, 99, 132, 0.5)",
                borderColor: "rgba(255, 99, 132, 1)",
            },
        ],
    };

    if (graphicData == "money") chartData.datasets.pop();
    if (graphicData == "sales") chartData.datasets.shift();

    const chartOptions = {
        responsive: true,
        plugins: {
            legend: {
                position: "top",
            },
            title: {
                display: true,
                text: `Estadísticas de ventas del año ${data[0].year}`,
            },
        },
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    };

    return <Line data={chartData} options={chartOptions} />;
}
