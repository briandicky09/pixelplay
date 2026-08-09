import { Link, useNavigate, useLocation } from "react-router-dom";
import type { ReactNode, MouseEvent } from "react";

type HashLinkProps = {
  hash?: string;
  className?: string;
  children: ReactNode;
  onClick?: () => void;
};

/**
 * Navigates to "/" (if not already there) and smooth-scrolls to a section
 * id. Falls back to a plain home link when no hash is given.
 */
export function HashLink({ hash, className, children, onClick }: HashLinkProps) {
  const navigate = useNavigate();
  const location = useLocation();

  const scrollToHash = () => {
    if (!hash) return;
    const el = document.getElementById(hash);
    if (el) el.scrollIntoView({ behavior: "smooth", block: "start" });
  };

  const handleClick = (event: MouseEvent<HTMLAnchorElement>) => {
    onClick?.();
    if (!hash) {
      // "Beranda" link: always scroll to top, whether we're already on
      // "/" (no route change means App's scroll manager won't fire) or
      // navigating there from another page.
      if (location.pathname === "/") {
        event.preventDefault();
        window.scrollTo({ top: 0, behavior: "smooth" });
      }
      return;
    }
    if (location.pathname === "/") {
      event.preventDefault();
      scrollToHash();
    } else {
      event.preventDefault();
      navigate(`/#${hash}`);
      window.setTimeout(scrollToHash, 60);
    }
  };

  return (
    <Link to={hash ? `/#${hash}` : "/"} className={className} onClick={handleClick}>
      {children}
    </Link>
  );
}
