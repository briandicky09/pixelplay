import { Link } from "react-router-dom";
import logo from "@/assets/logo-icon.png";

type BrandProps = {
  size?: "sm" | "md";
};

/** Logo lockup reused by the navbar and footer. */
export function Brand({ size = "md" }: BrandProps) {
  return (
    <Link to="/" className="flex items-center gap-2" aria-label="PixelPlay — ke beranda">
      <img
        src={logo}
        alt="Logo PixelPlay"
        width={256}
        height={256}
        className={size === "md" ? "h-8 w-8 object-contain" : "h-7 w-7 object-contain"}
      />
      <span
        className={`font-display font-bold tracking-tight text-white ${
          size === "md" ? "text-lg" : "text-base"
        }`}
      >
        PixelPlay
      </span>
    </Link>
  );
}
