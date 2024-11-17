import React from "react";
import { FaStar, FaStarHalf } from "react-icons/fa";

export const StarsRating = ({ rating }) => {
    const maxStars = 5;

    return (
        <div className="flex items-center space-x-1">
            {[...Array(maxStars)].map((_, index) => {
                if (index < Math.floor(rating)) {
                    return <FaStar key={index} className="text-2xl text-purple-700" />;
                } else if (index < rating && index + 1 > rating) {
                    return (
                        <div className="flex relative" key={index}>
                            <FaStarHalf className="absolute top-0 left-0 text-2xl text-purple-700" />
                            <FaStarHalf className="text-2xl text-purple-200 scale-x-[-1]" />
                        </div>
                    );
                } else {
                    return <FaStar key={index} className="text-2xl text-purple-200" />;
                }
            })}
        </div>
    );
};
