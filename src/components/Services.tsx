import { motion } from "framer-motion";
import { Flame, Shield, Bell, Users, Wrench, FileCheck } from "lucide-react";
import fireEquipment from "@/assets/fire-equipment.jpg";
import fireTraining from "@/assets/fire-training.jpg";
import fireAlarm from "@/assets/fire-alarm.jpg";

const services = [
  {
    icon: Flame,
    title: "Fire Extinguisher Services",
    description:
      "Complete fire extinguisher supply, installation, and maintenance for all facility types.",
    image: fireEquipment,
  },
  {
    icon: Bell,
    title: "Fire Alarm Systems",
    description:
      "State-of-the-art fire detection and alarm systems with 24/7 monitoring capabilities.",
    image: fireAlarm,
  },
  {
    icon: Users,
    title: "Safety Training",
    description:
      "Comprehensive fire safety training programs for employees and emergency response teams.",
    image: fireTraining,
  },
  {
    icon: Shield,
    title: "Fire Risk Assessment",
    description:
      "Thorough evaluation of your premises to identify and mitigate fire hazards.",
    image: null,
  },
  {
    icon: Wrench,
    title: "System Maintenance",
    description:
      "Regular inspection and maintenance of all fire protection equipment and systems.",
    image: null,
  },
  {
    icon: FileCheck,
    title: "Compliance Services",
    description:
      "Ensure your business meets all local and national fire safety regulations.",
    image: null,
  },
];

const containerVariants = {
  hidden: { opacity: 0 },
  visible: {
    opacity: 1,
    transition: {
      staggerChildren: 0.1,
    },
  },
};

const itemVariants = {
  hidden: { opacity: 0, y: 30 },
  visible: {
    opacity: 1,
    y: 0,
    transition: { duration: 0.6, ease: "easeOut" as const },
  },
};

export const Services = () => {
  return (
    <section id="services" className="py-24 bg-muted/50">
      <div className="container mx-auto px-4 lg:px-8">
        {/* Section Header */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6 }}
          className="text-center mb-16"
        >
          <span className="inline-block text-primary font-semibold mb-4 tracking-wider uppercase text-sm">
            What We Offer
          </span>
          <h2 className="font-display text-4xl sm:text-5xl lg:text-6xl text-foreground mb-6">
            OUR FIRE SAFETY SERVICES
          </h2>
          <p className="text-muted-foreground max-w-2xl mx-auto text-lg">
            Comprehensive fire protection solutions tailored to meet your specific
            needs and ensure complete safety for your property and people.
          </p>
        </motion.div>

        {/* Services Grid */}
        <motion.div
          variants={containerVariants}
          initial="hidden"
          whileInView="visible"
          viewport={{ once: true }}
          className="grid md:grid-cols-2 lg:grid-cols-3 gap-6"
        >
          {services.map((service, index) => (
            <motion.div
              key={service.title}
              variants={itemVariants}
              className="group relative bg-card rounded-2xl overflow-hidden shadow-card hover-lift cursor-pointer"
            >
              {service.image ? (
                <div className="h-48 overflow-hidden">
                  <img
                    src={service.image}
                    alt={service.title}
                    className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-card via-card/50 to-transparent" />
                </div>
              ) : (
                <div className="h-32 gradient-fire opacity-90" />
              )}
              
              <div className={`p-6 ${service.image ? "-mt-16 relative z-10" : ""}`}>
                <div
                  className={`w-14 h-14 rounded-xl flex items-center justify-center mb-4 ${
                    service.image
                      ? "gradient-fire shadow-fire"
                      : "bg-primary-foreground/20"
                  }`}
                >
                  <service.icon
                    className={`w-7 h-7 ${
                      service.image ? "text-primary-foreground" : "text-primary-foreground"
                    }`}
                  />
                </div>
                <h3 className="font-display text-2xl text-card-foreground mb-3 tracking-wide">
                  {service.title.toUpperCase()}
                </h3>
                <p className="text-muted-foreground leading-relaxed">
                  {service.description}
                </p>
              </div>

              {/* Hover Border Effect */}
              <div className="absolute inset-0 border-2 border-transparent group-hover:border-primary/50 rounded-2xl transition-colors duration-300" />
            </motion.div>
          ))}
        </motion.div>
      </div>
    </section>
  );
};
