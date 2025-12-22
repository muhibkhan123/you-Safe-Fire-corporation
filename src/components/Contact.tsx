import { useState } from "react";
import { motion } from "framer-motion";
import { Phone, Mail, MapPin, Send, Clock } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { toast } from "@/hooks/use-toast";

const contactInfo = [
  {
    icon: Phone,
    title: "Call Us",
    value: "+1 (234) 567-8900",
    subtitle: "24/7 Emergency Line",
  },
  {
    icon: Mail,
    title: "Email Us",
    value: "info@yousafe.com",
    subtitle: "We reply within 24 hours",
  },
  {
    icon: MapPin,
    title: "Visit Us",
    value: "123 Safety Street",
    subtitle: "Fire City, FC 12345",
  },
  {
    icon: Clock,
    title: "Working Hours",
    value: "Mon - Fri: 8AM - 6PM",
    subtitle: "Weekend: Emergency Only",
  },
];

export const Contact = () => {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    message: "",
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    toast({
      title: "Message Sent!",
      description: "We'll get back to you within 24 hours.",
    });
    setFormData({ name: "", email: "", phone: "", message: "" });
  };

  return (
    <section id="contact" className="py-24 bg-background">
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
            Get In Touch
          </span>
          <h2 className="font-display text-4xl sm:text-5xl lg:text-6xl text-foreground mb-6">
            CONTACT US TODAY
          </h2>
          <p className="text-muted-foreground max-w-2xl mx-auto text-lg">
            Ready to protect your property? Get in touch with our fire safety
            experts for a free consultation and quote.
          </p>
        </motion.div>

        <div className="grid lg:grid-cols-2 gap-12 items-start">
          {/* Contact Info */}
          <motion.div
            initial={{ opacity: 0, x: -50 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8 }}
          >
            <div className="grid sm:grid-cols-2 gap-6 mb-8">
              {contactInfo.map((info, index) => (
                <motion.div
                  key={info.title}
                  initial={{ opacity: 0, y: 20 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  viewport={{ once: true }}
                  transition={{ duration: 0.5, delay: index * 0.1 }}
                  className="p-6 bg-card rounded-2xl shadow-card hover-lift"
                >
                  <div className="w-12 h-12 gradient-fire rounded-xl flex items-center justify-center mb-4">
                    <info.icon className="w-6 h-6 text-primary-foreground" />
                  </div>
                  <h4 className="font-semibold text-card-foreground mb-1">
                    {info.title}
                  </h4>
                  <p className="text-card-foreground font-medium">{info.value}</p>
                  <p className="text-sm text-muted-foreground">{info.subtitle}</p>
                </motion.div>
              ))}
            </div>

            {/* Emergency Box */}
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.6, delay: 0.4 }}
              className="gradient-fire rounded-2xl p-8 shadow-fire"
            >
              <h3 className="font-display text-3xl text-primary-foreground mb-4">
                EMERGENCY?
              </h3>
              <p className="text-primary-foreground/80 mb-6">
                Our emergency response team is available 24/7. Don't hesitate
                to call us for any fire-related emergencies.
              </p>
              <a
                href="tel:+1234567890"
                className="inline-flex items-center gap-2 bg-primary-foreground text-primary font-semibold px-6 py-3 rounded-xl hover:bg-primary-foreground/90 transition-colors"
              >
                <Phone className="w-5 h-5" />
                Call Emergency Line
              </a>
            </motion.div>
          </motion.div>

          {/* Contact Form */}
          <motion.div
            initial={{ opacity: 0, x: 50 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8 }}
            className="bg-card rounded-2xl p-8 shadow-card"
          >
            <h3 className="font-display text-3xl text-card-foreground mb-6">
              SEND US A MESSAGE
            </h3>
            <form onSubmit={handleSubmit} className="space-y-6">
              <div className="grid sm:grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-medium text-card-foreground mb-2">
                    Your Name
                  </label>
                  <Input
                    placeholder="John Doe"
                    value={formData.name}
                    onChange={(e) =>
                      setFormData({ ...formData, name: e.target.value })
                    }
                    required
                    className="h-12"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-card-foreground mb-2">
                    Phone Number
                  </label>
                  <Input
                    type="tel"
                    placeholder="+1 (234) 567-8900"
                    value={formData.phone}
                    onChange={(e) =>
                      setFormData({ ...formData, phone: e.target.value })
                    }
                    className="h-12"
                  />
                </div>
              </div>
              <div>
                <label className="block text-sm font-medium text-card-foreground mb-2">
                  Email Address
                </label>
                <Input
                  type="email"
                  placeholder="john@example.com"
                  value={formData.email}
                  onChange={(e) =>
                    setFormData({ ...formData, email: e.target.value })
                  }
                  required
                  className="h-12"
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-card-foreground mb-2">
                  Your Message
                </label>
                <Textarea
                  placeholder="Tell us about your fire safety needs..."
                  value={formData.message}
                  onChange={(e) =>
                    setFormData({ ...formData, message: e.target.value })
                  }
                  required
                  rows={5}
                />
              </div>
              <Button type="submit" variant="fire" size="lg" className="w-full group">
                Send Message
                <Send className="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" />
              </Button>
            </form>
          </motion.div>
        </div>
      </div>
    </section>
  );
};
