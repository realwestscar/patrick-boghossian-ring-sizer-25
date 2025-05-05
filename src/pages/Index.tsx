
import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import RingSizeVisualizer from '@/components/RingSizeVisualizer';
import MeasurementControls from '@/components/MeasurementControls';
import SizeTable from '@/components/SizeTable';
import ShareButton from '@/components/ShareButton';
import { toast } from 'sonner';
import { useOrientation } from '@/hooks/use-orientation';
import { useIsMobile } from '@/hooks/use-mobile';

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

const Index = () => {
  const [unit, setUnit] = useState<'mm' | 'inches'>('mm');
  const [measurementType, setMeasurementType] = useState<'diameter' | 'circumference'>('diameter');
  const [diameterMm, setDiameterMm] = useState(17.3); // US size 7 as default
  const [currentRingSize, setCurrentRingSize] = useState({
    diameterMm: 17.3,
    us: "7",
    uk: "N 1/2",
    eu: "54 1/2",
    jp: "14"
  });
  const [isFullscreen, setIsFullscreen] = useState(false);
  
  const orientation = useOrientation();
  const isMobile = useIsMobile();

  useEffect(() => {
    // Check if device orientation changed and show a toast with instructions
    const handleOrientationChange = () => {
      if (isMobile) {
        if (orientation === 'landscape') {
          toast("Landscape mode detected", {
            description: "This view provides better precision for measuring rings",
            icon: "📏"
          });
        }
      }
    };
    
    handleOrientationChange();
    
    // Welcome toast only on first load
    toast("Welcome to Ring Sizer", {
      description: "Adjust the circle to find your perfect ring size",
      icon: "💍"
    });
    
    // Show usage tips after a short delay
    const tipTimer = setTimeout(() => {
      toast("Pro tip!", {
        description: isMobile 
          ? "Touch and drag the circle to resize, or pinch to zoom"
          : "Click and drag the circle to resize precisely", 
        icon: "💡"
      });
    }, 6000);
    
    return () => clearTimeout(tipTimer);
  }, [orientation, isMobile]);

  // Find the closest ring size for the current diameter
  useEffect(() => {
    const findClosestSize = () => {
      // Find exact match or closest
      let closest = ringSizeData[0];
      let minDiff = Math.abs(ringSizeData[0].diameterMm - diameterMm);
      
      for (const item of ringSizeData) {
        const diff = Math.abs(item.diameterMm - diameterMm);
        if (diff < minDiff) {
          minDiff = diff;
          closest = item;
        }
      }
      
      setCurrentRingSize({
        diameterMm: closest.diameterMm,
        us: closest.us,
        uk: closest.uk,
        eu: closest.eu,
        jp: closest.jp
      });
      
      // Haptic feedback when matching a standard size
      if (minDiff < 0.05 && window.navigator.vibrate) {
        window.navigator.vibrate([30, 30, 30]);
      }
    };

    findClosestSize();
  }, [diameterMm]);

  const handleSizeChange = (newDiameterMm: number) => {
    setDiameterMm(newDiameterMm);
  };

  const toggleFullscreen = () => {
    if (!document.fullscreenElement) {
      document.documentElement.requestFullscreen().catch(e => {
        console.log(`Error attempting to enable fullscreen: ${e.message}`);
      });
      setIsFullscreen(true);
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen();
        setIsFullscreen(false);
      }
    }
  };

  return (
    <div className="min-h-screen flex flex-col">
      <motion.div 
        className="fixed inset-0 pointer-events-none bg-gradient-to-b from-burgundy/5 to-gold/5 z-[-1]"
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        transition={{ duration: 1 }}
      />
      
      {/* Conditional rendering for header based on orientation on mobile */}
      {!(isMobile && orientation === 'landscape') && <Header />}
      
      <main className={`flex-1 px-4 ${
        isMobile && orientation === 'landscape' ? 'py-2' : 'py-8'
      } container`}>
        {/* Controls positioned based on orientation */}
        <div className={`${
          isMobile && orientation === 'landscape' ? 'flex flex-col items-start space-y-2' : ''
        }`}>
          <MeasurementControls 
            unit={unit} 
            setUnit={setUnit} 
            measurementType={measurementType}
            setMeasurementType={setMeasurementType}
          />
          
          {isMobile && (
            <motion.button
              className="glassmorphism px-4 py-2 rounded-full text-sm flex items-center justify-center mx-auto mb-4"
              onClick={toggleFullscreen}
              whileTap={{ scale: 0.95 }}
            >
              {isFullscreen ? "Exit Fullscreen" : "Fullscreen Mode"}
            </motion.button>
          )}
        </div>
        
        <RingSizeVisualizer 
          unit={unit} 
          measurementType={measurementType}
          onSizeChange={handleSizeChange}
        />
        
        {/* Adjust layout of bottom components based on orientation */}
        <div className={`${
          isMobile && orientation === 'landscape' 
            ? 'grid grid-cols-2 gap-4' 
            : 'space-y-6'
        }`}>
          <SizeTable diameterMm={diameterMm} />
          
          <ShareButton ringSize={currentRingSize} />
        </div>
      </main>
      
      {/* Conditional rendering for footer based on orientation on mobile */}
      {!(isMobile && orientation === 'landscape') && <Footer />}
    </div>
  );
};

export default Index;
