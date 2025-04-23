import React from "react";
import { FaStar, FaStarHalf } from "react-icons/fa";

export const StarsRating = ({ rating, size = 15 }) => {
    const maxStars = 5;

    return (
        <div className="flex items-center space-x-1">
            {[...Array(maxStars)].map((_, index) => {
                if (index < Math.floor(rating)) {
                    return <FaStar size={size} key={index} className="text-2xl text-purple-700" />;
                } else if (index < rating && index + 1 > rating) {
                    return (
                        <div className="flex relative" key={index}>
                            <FaStarHalf size={size} className="absolute top-0 left-0 text-2xl text-purple-700" />
                            <FaStarHalf size={size} className="text-2xl text-purple-200 scale-x-[-1]" />
                        </div>
                    );
                } else {
                    return <FaStar size={size} key={index} className="text-2xl text-purple-200" />;
                }
            })}
        </div>
    );
};
