import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

interface SizeTableProps {
  diameterMm: number;
}

// Ring size conversion table (expanded version)
const ringSizeData = [
  { diameterMm: 14.1, us: "3", uk: "F", eu: "44", jp: "4", cn: "4" },
  { diameterMm: 14.5, us: "3.5", uk: "G", eu: "46 1/4", jp: "5", cn: "5" },
  { diameterMm: 14.9, us: "4", uk: "H 1/2", eu: "47 3/4", jp: "7", cn: "7" },
  { diameterMm: 15.3, us: "4.5", uk: "I 1/2", eu: "48 3/4", jp: "8", cn: "8" },
  { diameterMm: 15.7, us: "5", uk: "J 1/2", eu: "50", jp: "9", cn: "9" },
  { diameterMm: 16.1, us: "5.5", uk: "K 1/2", eu: "51 1/4", jp: "10", cn: "10" },
  { diameterMm: 16.5, us: "6", uk: "L 1/2", eu: "52 1/2", jp: "12", cn: "12" },
  { diameterMm: 16.9, us: "6.5", uk: "M 1/2", eu: "53 3/4", jp: "13", cn: "13" },
  { diameterMm: 17.3, us: "7", uk: "N 1/2", eu: "54 1/2", jp: "14", cn: "14" },
  { diameterMm: 17.7, us: "7.5", uk: "O 1/2", eu: "55 3/4", jp: "15", cn: "15" },
  { diameterMm: 18.1, us: "8", uk: "P 1/2", eu: "57", jp: "16", cn: "16" },
  { diameterMm: 18.5, us: "8.5", uk: "Q 1/2", eu: "58 1/4", jp: "17", cn: "17" },
  { diameterMm: 18.9, us: "9", uk: "R 1/2", eu: "59 1/2", jp: "18", cn: "18" },
  { diameterMm: 19.3, us: "9.5", uk: "S 1/2", eu: "60 3/4", jp: "19", cn: "19" },
  { diameterMm: 19.7, us: "10", uk: "T 1/2", eu: "62", jp: "20", cn: "20" },
  { diameterMm: 20.1, us: "10.5", uk: "U 1/2", eu: "63 1/4", jp: "22", cn: "22" },
  { diameterMm: 20.5, us: "11", uk: "V 1/2", eu: "64 1/2", jp: "23", cn: "23" },
  { diameterMm: 20.9, us: "11.5", uk: "W 1/2", eu: "65 3/4", jp: "24", cn: "24" },
  { diameterMm: 21.3, us: "12", uk: "X 1/2", eu: "67", jp: "25", cn: "25" },
  { diameterMm: 21.7, us: "12.5", uk: "Z", eu: "68 1/4", jp: "26", cn: "26" },
  { diameterMm: 22.1, us: "13", uk: "Z+1", eu: "69 1/2", jp: "27", cn: "27" },
];

const SizeTable: React.FC<SizeTableProps> = ({ diameterMm }) => {
  const [activeTab, setActiveTab] = useState('usa');

  // Find the closest sizes
  const findClosestSize = () => {
    // Find exact match
    const exactMatch = ringSizeData.find(item => Math.abs(item.diameterMm - diameterMm) < 0.05);
    if (exactMatch) return exactMatch;

    // Find closest match
    let closest = ringSizeData[0];
    let minDiff = Math.abs(ringSizeData[0].diameterMm - diameterMm);
    
    for (const item of ringSizeData) {
      const diff = Math.abs(item.diameterMm - diameterMm);
      if (diff < minDiff) {
        minDiff = diff;
        closest = item;
      }
    }
    
    return closest;
  };

  const closestSize = findClosestSize();

  // Get adjacent sizes for context
  const closestIndex = ringSizeData.findIndex(item => item.diameterMm === closestSize.diameterMm);
  const showPrev = closestIndex > 0;
  const showNext = closestIndex < ringSizeData.length - 1;
  
  const prevSize = showPrev ? ringSizeData[closestIndex - 1] : null;
  const nextSize = showNext ? ringSizeData[closestIndex + 1] : null;

  return (
    <motion.div 
      className="w-full max-w-xl mx-auto"
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.6, delay: 0.3 }}
    >
      <Tabs defaultValue="usa" className="w-full" onValueChange={setActiveTab}>
        <TabsList className="mb-4 glassmorphism">
          <TabsTrigger value="usa" className="flex-1 md:flex-none text-xs md:text-sm">USA</TabsTrigger>
          <TabsTrigger value="uk" className="flex-1 md:flex-none text-xs md:text-sm">UK/AU</TabsTrigger>
          <TabsTrigger value="eu" className="flex-1 md:flex-none text-xs md:text-sm">EU</TabsTrigger>
          <TabsTrigger value="asia" className="flex-1 md:flex-none text-xs md:text-sm">JP/CN</TabsTrigger>
        </TabsList>

        {/* USA Size Content */}
        <TabsContent value="usa" className="animate-fade-in">
          <div className="glassmorphism p-6 rounded-lg">
            <div className="text-center mb-4">
              <h2 className="text-2xl font-display">US Size</h2>
              <p className="text-sm text-burgundy/70">United States sizing standard</p>
            </div>
            
            <div className="grid grid-cols-3 gap-4 text-center">
              {showPrev && (
                <motion.div 
                  className="p-4 rounded-lg border border-burgundy/20 bg-cream/50"
                  initial={{ opacity: 0 }}
                  animate={{ opacity: 0.7 }}
                >
                  <div className="text-xl font-medium text-burgundy/70">{prevSize.us}</div>
                  <div className="text-xs text-burgundy/50">∅ {prevSize.diameterMm} mm</div>
                </motion.div>
              )}
              
              <motion.div 
                className="p-4 rounded-lg col-span-1 bg-burgundy text-cream shadow-lg"
                initial={{ scale: 0.95 }}
                animate={{ scale: 1 }}
                transition={{ type: "spring", stiffness: 400, damping: 10 }}
              >
                <div className="text-3xl font-semibold">{closestSize.us}</div>
                <div className="text-xs">∅ {closestSize.diameterMm} mm</div>
              </motion.div>
              
              {showNext && (
                <motion.div 
                  className="p-4 rounded-lg border border-burgundy/20 bg-cream/50"
                  initial={{ opacity: 0 }}
                  animate={{ opacity: 0.7 }}
                >
                  <div className="text-xl font-medium text-burgundy/70">{nextSize.us}</div>
                  <div className="text-xs text-burgundy/50">∅ {nextSize.diameterMm} mm</div>
                </motion.div>
              )}
            </div>
          </div>
        </TabsContent>

        {/* UK/AU Size Content */}
        <TabsContent value="uk" className="animate-fade-in">
          <div className="glassmorphism p-6 rounded-lg">
            <div className="text-center mb-4">
              <h2 className="text-2xl font-display">UK/AU Size</h2>
              <p className="text-sm text-burgundy/70">United Kingdom & Australia sizing standard</p>
            </div>
            
            <div className="grid grid-cols-3 gap-4 text-center">
              {showPrev && (
                <motion.div 
                  className="p-4 rounded-lg border border-burgundy/20 bg-cream/50"
                  initial={{ opacity: 0 }}
                  animate={{ opacity: 0.7 }}
                >
                  <div className="text-xl font-medium text-burgundy/70">{prevSize.uk}</div>
                  <div className="text-xs text-burgundy/50">∅ {prevSize.diameterMm} mm</div>
                </motion.div>
              )}
              
              <motion.div 
                className="p-4 rounded-lg col-span-1 bg-burgundy text-cream shadow-lg"
                initial={{ scale: 0.95 }}
                animate={{ scale: 1 }}
                transition={{ type: "spring", stiffness: 400, damping: 10 }}
              >
                <div className="text-3xl font-semibold">{closestSize.uk}</div>
                <div className="text-xs">∅ {closestSize.diameterMm} mm</div>
              </motion.div>
              
              {showNext && (
                <motion.div 
                  className="p-4 rounded-lg border border-burgundy/20 bg-cream/50"
                  initial={{ opacity: 0 }}
                  animate={{ opacity: 0.7 }}
                >
                  <div className="text-xl font-medium text-burgundy/70">{nextSize.uk}</div>
                  <div className="text-xs text-burgundy/50">∅ {nextSize.diameterMm} mm</div>
                </motion.div>
              )}
            </div>
          </div>
        </TabsContent>

        {/* EU Size Content */}
        <TabsContent value="eu" className="animate-fade-in">
          <div className="glassmorphism p-6 rounded-lg">
            <div className="text-center mb-4">
              <h2 className="text-2xl font-display">EU Size</h2>
              <p className="text-sm text-burgundy/70">European sizing standard</p>
            </div>
            
            <div className="grid grid-cols-3 gap-4 text-center">
              {showPrev && (
                <motion.div 
                  className="p-4 rounded-lg border border-burgundy/20 bg-cream/50"
                  initial={{ opacity: 0 }}
                  animate={{ opacity: 0.7 }}
                >
                  <div className="text-xl font-medium text-burgundy/70">{prevSize.eu}</div>
                  <div className="text-xs text-burgundy/50">∅ {prevSize.diameterMm} mm</div>
                </motion.div>
              )}
              
              <motion.div 
                className="p-4 rounded-lg col-span-1 bg-burgundy text-cream shadow-lg"
                initial={{ scale: 0.95 }}
                animate={{ scale: 1 }}
                transition={{ type: "spring", stiffness: 400, damping: 10 }}
              >
                <div className="text-3xl font-semibold">{closestSize.eu}</div>
                <div className="text-xs">∅ {closestSize.diameterMm} mm</div>
              </motion.div>
              
              {showNext && (
                <motion.div 
                  className="p-4 rounded-lg border border-burgundy/20 bg-cream/50"
                  initial={{ opacity: 0 }}
                  animate={{ opacity: 0.7 }}
                >
                  <div className="text-xl font-medium text-burgundy/70">{nextSize.eu}</div>
                  <div className="text-xs text-burgundy/50">∅ {nextSize.diameterMm} mm</div>
                </motion.div>
              )}
            </div>
          </div>
        </TabsContent>

        {/* JP/CN Size Content */}
        <TabsContent value="asia" className="animate-fade-in">
          <div className="glassmorphism p-6 rounded-lg">
            <div className="text-center mb-4">
              <h2 className="text-2xl font-display">JP/CN Size</h2>
              <p className="text-sm text-burgundy/70">Japan & China sizing standard</p>
            </div>
            
            <div className="grid grid-cols-3 gap-4 text-center">
              {showPrev && (
                <motion.div 
                  className="p-4 rounded-lg border border-burgundy/20 bg-cream/50"
                  initial={{ opacity: 0 }}
                  animate={{ opacity: 0.7 }}
                >
                  <div className="text-xl font-medium text-burgundy/70">{prevSize.jp}</div>
                  <div className="text-xs text-burgundy/50">∅ {prevSize.diameterMm} mm</div>
                </motion.div>
              )}
              
              <motion.div 
                className="p-4 rounded-lg col-span-1 bg-burgundy text-cream shadow-lg"
                initial={{ scale: 0.95 }}
                animate={{ scale: 1 }}
                transition={{ type: "spring", stiffness: 400, damping: 10 }}
              >
                <div className="text-3xl font-semibold">{closestSize.jp}</div>
                <div className="text-xs">∅ {closestSize.diameterMm} mm</div>
              </motion.div>
              
              {showNext && (
                <motion.div 
                  className="p-4 rounded-lg border border-burgundy/20 bg-cream/50"
                  initial={{ opacity: 0 }}
                  animate={{ opacity: 0.7 }}
                >
                  <div className="text-xl font-medium text-burgundy/70">{nextSize.jp}</div>
                  <div className="text-xs text-burgundy/50">∅ {nextSize.diameterMm} mm</div>
                </motion.div>
              )}
            </div>
          </div>
        </TabsContent>
      </Tabs>
    </motion.div>
  );
};

export default SizeTable;
