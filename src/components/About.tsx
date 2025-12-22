import { motion } from "framer-motion";
import { Award, Users, Clock, Target } from "lucide-react";
import { Button } from "@/components/ui/button";

const stats = [
  { icon: Award, value: "25+", label: "Years of Excellence" },
  { icon: Users, value: "10,000+", label: "Satisfied Clients" },
  { icon: Clock, value: "24/7", label: "Emergency Support" },
  { icon: Target, value: "100%", label: "Success Rate" },
];

const values = [
  {
    title: "Safety First",
    description: "We prioritize the safety of your people and property above everything else.",
  },
  {
    title: "Expert Team",
    description: "Our certified professionals bring decades of combined experience.",
  },
  {
    title: "Cutting-Edge Technology",
    description: "We use the latest fire protection systems and equipment.",
  },
  {
    title: "Reliable Service",
    description: "Count on us for prompt, dependable service whenever you need it.",
  },
];

export const About = () => {
  return (
    <section id="about" className="py-24 bg-accent text-accent-foreground overflow-hidden">
      <div className="container mx-auto px-4 lg:px-8">
        <div className="grid lg:grid-cols-2 gap-16 items-center">
          {/* Left Content */}
          <motion.div
            initial={{ opacity: 0, x: -50 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8 }}
          >
            <span className="inline-block text-fire-orange font-semibold mb-4 tracking-wider uppercase text-sm">
              About Us
            </span>
            <h2 className="font-display text-4xl sm:text-5xl lg:text-6xl mb-6 leading-tight">
              YOUR TRUSTED
              <br />
              <span className="text-gradient-fire">FIRE SAFETY</span>
              <br />
              PARTNER
            </h2>
            <p className="text-accent-foreground/70 text-lg mb-8 leading-relaxed">
              Since 1998, You-Safe Fire Corporation has been the leading provider
              of fire protection services. We've built our reputation on
              reliability, expertise, and an unwavering commitment to keeping
              our clients safe.
            </p>
            <p className="text-accent-foreground/70 text-lg mb-8 leading-relaxed">
              Our team of certified fire safety professionals works tirelessly to
              ensure your complete protection, from initial assessment to ongoing
              maintenance and emergency response.
            </p>

            {/* Values Grid */}
            <div className="grid sm:grid-cols-2 gap-4 mb-8">
              {values.map((value, index) => (
                <motion.div
                  key={value.title}
                  initial={{ opacity: 0, y: 20 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  viewport={{ once: true }}
                  transition={{ duration: 0.5, delay: index * 0.1 }}
                  className="p-4 bg-accent-foreground/5 rounded-xl border border-accent-foreground/10"
                >
                  <h4 className="font-semibold text-accent-foreground mb-1">
                    {value.title}
                  </h4>
                  <p className="text-sm text-accent-foreground/60">
                    {value.description}
                  </p>
                </motion.div>
              ))}
            </div>

            <Button variant="fire" size="lg">
              Learn More About Us
            </Button>
          </motion.div>

          {/* Right - Stats */}
          <motion.div
            initial={{ opacity: 0, x: 50 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8 }}
            className="relative"
          >
            {/* Decorative Background */}
            <div className="absolute -top-20 -right-20 w-64 h-64 bg-fire-orange/10 rounded-full blur-3xl" />
            <div className="absolute -bottom-20 -left-20 w-64 h-64 bg-primary/10 rounded-full blur-3xl" />

            <div className="relative grid grid-cols-2 gap-6">
              {stats.map((stat, index) => (
                <motion.div
                  key={stat.label}
                  initial={{ opacity: 0, scale: 0.9 }}
                  whileInView={{ opacity: 1, scale: 1 }}
                  viewport={{ once: true }}
                  transition={{ duration: 0.5, delay: index * 0.1 }}
                  className={`p-8 rounded-2xl text-center ${
                    index % 2 === 0
                      ? "bg-accent-foreground/5 border border-accent-foreground/10"
                      : "gradient-fire shadow-fire"
                  }`}
                >
                  <stat.icon
                    className={`w-10 h-10 mx-auto mb-4 ${
                      index % 2 === 0 ? "text-fire-orange" : "text-primary-foreground"
                    }`}
                  />
                  <div
                    className={`font-display text-4xl sm:text-5xl mb-2 ${
                      index % 2 === 0 ? "text-accent-foreground" : "text-primary-foreground"
                    }`}
                  >
                    {stat.value}
                  </div>
                  <div
                    className={`text-sm font-medium ${
                      index % 2 === 0
                        ? "text-accent-foreground/60"
                        : "text-primary-foreground/80"
                    }`}
                  >
                    {stat.label}
                  </div>
                </motion.div>
              ))}
            </div>
          </motion.div>
        </div>
      </div>
    </section>
  );
};
