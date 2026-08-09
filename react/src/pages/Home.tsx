import { useEffect } from "react";
import { HeroSlider } from "@/components/HeroSlider";
import { DealsSection } from "@/components/DealsSection";
import { GameCatalog } from "@/components/GameCatalog";
import { CategorySection } from "@/components/CategorySection";
import { TrendingSection } from "@/components/TrendingSection";
import { WhySection } from "@/components/WhySection";
import { CtaSection } from "@/components/CtaSection";
import { games } from "@/data/games";

export default function HomePage() {
  const featured = games.filter((game) => game.featured);

  useEffect(() => {
    document.title = "PixelPlay — Marketplace Game Digital PC & Konsol";
  }, []);

  return (
    <>
      <HeroSlider slides={featured.length > 0 ? featured : games} />
      <DealsSection />
      <GameCatalog />
      <CategorySection />
      <TrendingSection />
      <WhySection />
      <CtaSection />
    </>
  );
}
