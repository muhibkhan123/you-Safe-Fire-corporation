import { motion } from "framer-motion";
import { Shield, ArrowRight, CheckCircle } from "lucide-react";
import { Button } from "@/components/ui/button";
import heroImage from "@/assets/hero-fire-safety.jpg";
const features = ["24/7 Emergency Response", "Certified Professionals", "Complete Fire Protection"];
export const Hero = () => {
  return <section id="home" className="relative min-h-screen flex items-center justify-center overflow-hidden">
      {/* Background Image */}
      <div className="absolute inset-0 z-0">
        <img src={heroImage} alt="Professional firefighters at training" className="w-full h-full object-cover" />
        <div className="absolute inset-0 bg-gradient-to-r from-charcoal/95 via-charcoal/80 to-transparent" />
        <div className="absolute inset-0 bg-gradient-to-t from-charcoal/60 to-transparent" />
      </div>

      {/* Content */}
      <div className="container mx-auto px-4 lg:px-8 relative z-10 pt-20">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          <div className="text-center lg:text-left">
            {/* Badge */}
            <motion.div initial={{
            opacity: 0,
            y: 20
          }} animate={{
            opacity: 1,
            y: 0
          }} transition={{
            duration: 0.6
          }} className="inline-flex items-center gap-2 bg-primary/20 backdrop-blur-sm border border-primary/30 rounded-full px-4 py-2 mb-6 my-[10px]">
              <Shield className="w-4 h-4 text-fire-orange" />
              <span className="text-sm font-medium text-primary-foreground/90">
                Trusted Fire Safety Experts
              </span>
            </motion.div>

            {/* Heading */}
            <motion.h1 initial={{
            opacity: 0,
            y: 30
          }} animate={{
            opacity: 1,
            y: 0
          }} transition={{
            duration: 0.6,
            delay: 0.1
          }} className="font-display text-5xl sm:text-6xl lg:text-7xl xl:text-8xl leading-none mb-6 text-primary-foreground">
              PROTECTING
              <br />
              <span className="text-gradient-fire">WHAT MATTERS</span>
              <br />
              MOST
            </motion.h1>

            {/* Description */}
            <motion.p initial={{
            opacity: 0,
            y: 30
          }} animate={{
            opacity: 1,
            y: 0
          }} transition={{
            duration: 0.6,
            delay: 0.2
          }} className="text-lg text-primary-foreground/70 mb-8 max-w-xl mx-auto lg:mx-0">
              You-Safe Fire Corporation delivers comprehensive fire protection
              solutions for homes, businesses, and industrial facilities.
              Your safety is our mission.
            </motion.p>

            {/* Features */}
            <motion.div initial={{
            opacity: 0,
            y: 30
          }} animate={{
            opacity: 1,
            y: 0
          }} transition={{
            duration: 0.6,
            delay: 0.3
          }} className="flex flex-wrap justify-center lg:justify-start gap-4 mb-8">
              {features.map(feature => <div key={feature} className="flex items-center gap-2 text-primary-foreground/80">
                  <CheckCircle className="w-5 h-5 text-fire-orange" />
                  <span className="text-sm font-medium">{feature}</span>
                </div>)}
            </motion.div>

            {/* CTA Buttons */}
            <motion.div initial={{
            opacity: 0,
            y: 30
          }} animate={{
            opacity: 1,
            y: 0
          }} transition={{
            duration: 0.6,
            delay: 0.4
          }} className="flex-wrap justify-center gap-4 mx-0 my-[10px] flex flex-col lg:flex-col lg:flex lg:items-start lg:justify-center">
              <Button variant="fire" size="xl" className="group">
                Get Free Consultation
                <ArrowRight className="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" />
              </Button>
              <Button variant="hero" size="xl">
                Our Services
              </Button>
            </motion.div>
          </div>

          {/* Stats Card */}
          <motion.div initial={{
          opacity: 0,
          scale: 0.9
        }} animate={{
          opacity: 1,
          scale: 1
        }} transition={{
          duration: 0.8,
          delay: 0.5
        }} className="hidden lg:block">
            <div className="bg-primary-foreground/10 backdrop-blur-md border border-primary-foreground/20 rounded-2xl p-8 max-w-md ml-auto">
              <div className="grid grid-cols-2 gap-6">
                <div className="text-center p-4">
                  <div className="font-display text-5xl text-fire-orange mb-2">
                    25+
                  </div>
                  <div className="text-sm text-primary-foreground/70">
                    Years Experience
                  </div>
                </div>
                <div className="text-center p-4">
                  <div className="font-display text-5xl text-fire-orange mb-2">
                    5000+
                  </div>
                  <div className="text-sm text-primary-foreground/70">
                    Projects Completed
                  </div>
                </div>
                <div className="text-center p-4">
                  <div className="font-display text-5xl text-fire-orange mb-2">
                    100%
                  </div>
                  <div className="text-sm text-primary-foreground/70">
                    Client Satisfaction
                  </div>
                </div>
                <div className="text-center p-4">
                  <div className="font-display text-5xl text-fire-orange mb-2">
                    24/7
                  </div>
                  <div className="text-sm text-primary-foreground/70">
                    Support Available
                  </div>
                </div>
              </div>
            </div>
          </motion.div>
        </div>
      </div>

      {/* Scroll Indicator */}
      <motion.div initial={{
      opacity: 0
    }} animate={{
      opacity: 1
    }} transition={{
      delay: 1,
      duration: 0.6
    }} className="absolute bottom-8 left-1/2 -translate-x-1/2 z-10">
        <div className="w-6 h-10 border-2 border-primary-foreground/30 rounded-full flex justify-center pt-2">
          <motion.div animate={{
          y: [0, 12, 0]
        }} transition={{
          duration: 1.5,
          repeat: Infinity
        }} className="w-1.5 h-1.5 bg-fire-orange rounded-full" />
        </div>
      </motion.div>
    </section>;
};