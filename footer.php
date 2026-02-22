<footer class="bg-background border-t border-border">
  <div class="container mx-auto px-6 py-20">
    <div class="grid md:grid-cols-4 gap-12 mb-16">
      <div class="md:col-span-2">
        <div class="flex items-center gap-2 mb-6">
          <span class="font-headline text-2xl tracking-[0.2em] gold-text">ASCEND</span>
          <span class="font-body text-[10px] tracking-[0.3em] text-muted-foreground uppercase">Aesthetics</span>
        </div>
        <p class="font-body text-xs text-muted-foreground leading-relaxed max-w-sm mb-6">
          Premium pharma-grade peptide compounds. Third-party verified.
          Engineered for laboratories that accept nothing less than absolute purity.
        </p>
        <p class="font-body text-[9px] tracking-[0.1em] text-primary/60 uppercase">
          Precision · Purity · Provenance
        </p>
      </div>

      <div>
        <h4 class="font-body text-[10px] tracking-[0.3em] uppercase text-primary mb-6">Navigate</h4>
        <div class="space-y-3">
          <a href="<?php echo esc_url(home_url('/#products')); ?>" class="block font-body text-xs text-muted-foreground hover:text-foreground transition-colors">Compounds</a>
          <a href="<?php echo esc_url(home_url('/#standards')); ?>" class="block font-body text-xs text-muted-foreground hover:text-foreground transition-colors">Standards</a>
          <a href="<?php echo esc_url(home_url('/#coa')); ?>" class="block font-body text-xs text-muted-foreground hover:text-foreground transition-colors">Transparency</a>
          <a href="<?php echo esc_url(home_url('/#about')); ?>" class="block font-body text-xs text-muted-foreground hover:text-foreground transition-colors">About</a>
          <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="block font-body text-xs text-muted-foreground hover:text-foreground transition-colors">Shop</a>
        </div>
      </div>

      <div>
        <h4 class="font-body text-[10px] tracking-[0.3em] uppercase text-primary mb-6">Legal</h4>
        <div class="space-y-3">
          <a href="#" class="block font-body text-xs text-muted-foreground hover:text-foreground transition-colors">Terms of Service</a>
          <a href="#" class="block font-body text-xs text-muted-foreground hover:text-foreground transition-colors">Shipping Policy</a>
          <a href="#" class="block font-body text-xs text-muted-foreground hover:text-foreground transition-colors">Returns</a>
        </div>
      </div>
    </div>

    <div class="border-t border-border pt-10 space-y-4">
      <div class="p-6 border border-border bg-card/30">
        <h5 class="font-body text-[9px] tracking-[0.3em] uppercase text-primary mb-3">
          Research Use Only Disclaimer
        </h5>
        <p class="font-body text-[10px] text-muted-foreground leading-relaxed">
          All products sold by Ascend Aesthetics are intended strictly for laboratory research use only.
          They are not intended for human consumption, diagnostic use, therapeutic application, or any form of clinical use.
          These products are not drugs, supplements, or food products. By purchasing, the buyer acknowledges the compounds
          will be used exclusively for legitimate scientific research purposes in accordance with applicable laws and regulations.
        </p>
      </div>

      <div class="p-6 border border-border bg-card/30">
        <h5 class="font-body text-[9px] tracking-[0.3em] uppercase text-primary mb-3">
          Shipping & Restrictions
        </h5>
        <p class="font-body text-[10px] text-muted-foreground leading-relaxed">
          Ascend Aesthetics ships to qualified research institutions and verified purchasers only.
          Shipping availability is subject to destination laws and regulations. It is the buyer's responsibility
          to ensure importation and use are permitted in their jurisdiction. Ascend Aesthetics reserves the right
          to decline orders that do not meet verification requirements.
        </p>
      </div>

      <div class="text-center pt-6">
        <p class="font-body text-[9px] text-muted-foreground/50 tracking-[0.1em]">
          © <?php echo esc_html(date('Y')); ?> Ascend Aesthetics. All rights reserved. Not for human consumption.
          Not for diagnostic or therapeutic use.
        </p>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>