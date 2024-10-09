import { IoSearch, IoMenu } from "react-icons/io5";
import { MdOutlineShoppingBag } from "react-icons/md";
import { TbLogin2 } from "react-icons/tb";
import { FaArrowUpFromBracket, FaArrowRight } from "react-icons/fa6";
import { HiPencil } from "react-icons/hi";

export const SearchIcon = ({ size = 20, ...props }) => (
    <IoSearch size={size} {...props} />
);

export const MenuIcon = ({ size = 20, ...props }) => (
    <IoMenu size={size} {...props} />
);

export const ShoppingBagIcon = ({ size = 20, ...props }) => (
    <MdOutlineShoppingBag size={size} {...props} />
);

export const LoginIcon = ({ size = 20, ...props }) => (
    <TbLogin2 size={size} {...props} />
);

export const RegisterIcon = ({ size = 20, ...props }) => (
    <FaArrowUpFromBracket size={size} {...props} />
);

export const ArrowRight = ({ size = 20, ...props }) => (
    <FaArrowRight size={size} {...props} />
)

export const PencilIcon = ({ size = 20, ...props }) => {
    <HiPencil size={size} {...props} />
}