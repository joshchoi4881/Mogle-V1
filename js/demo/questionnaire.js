let arr = [];
let results = [];
$(function() {
  $(".specificSkills").hide();
  $(".gig").hide();
  $("#COVID-19").change(function() {
    if ($(this).is(":checked")) {
      if ($("#RideshareOption").is(":checked")) {
        $("#RideshareOption").click();
      }
      $("#rideshareDiv").hide();
      if ($("#HandyOption").is(":checked")) {
        $("#HandyOption").click();
      }
      $("#HandyDiv").hide();
      if ($("#WagOption").is(":checked")) {
        $("#WagOption").click();
      }
      if ($("#RoverOption").is(":checked")) {
        $("#RoverOption").click();
      }
      if ($("#CareOption").is(":checked")) {
        $("#CareOption").click();
      }
      $("#specificCare").hide();
      if ($("#care").is(":checked")) {
        $("#care").click();
      }
      $("#careDiv").hide();
      if ($("#massage").is(":checked")) {
        $("#massage").click();
      }
      $("#massageDiv").hide();
      if ($("#GigFinesseOption").is(":checked")) {
        $("#GigFinesseOption").click();
      }
      $("#GigFinesseDiv").hide();
      if ($("#AssetCarOption").is(":checked")) {
        $("#AssetCarOption").click();
      }
      if ($("#AirbnbOption").is(":checked")) {
        $("#AirbnbOption").click();
      }
      $("#assets").hide();
    } else {
      $("#rideshareDiv").show();
      $("#HandyDiv").show();
      $("#careDiv").show();
      $("#massageDiv").show();
      $("#GigFinesseDiv").show();
      $("#assets").show();
    }
  });
  $("#driving").change(function() {
    if ($(this).is(":checked")) {
      $("#specificDriving").show();
    } else {
      if ($("#RideshareOption").is(":checked")) {
        $("#RideshareOption").click();
      }
      if ($("#DeliveryOption").is(":checked")) {
        $("#DeliveryOption").click();
      }
      if ($("#FoodDeliveryOption").is(":checked")) {
        $("#FoodDeliveryOption").click();
      }
      if ($("#GroceryDeliveryOption").is(":checked")) {
        $("#GroceryDeliveryOption").click();
      }
      $("#specificDriving").hide();
    }
  });
  $("#labor").change(function() {
    if ($(this).is(":checked")) {
      $("#specificLabor").show();
    } else {
      if ($("#AmazonDeliversWarehouseOption").is(":checked")) {
        $("#AmazonDeliversWarehouseOption").click();
      }
      if ($("#DollyHandsOption").is(":checked")) {
        $("#DollyHandsOption").click();
      }
      if ($("#TaskEasyOption").is(":checked")) {
        $("#TaskEasyOption").click();
      }
      if ($("#HandyOption").is(":checked")) {
        $("#HandyOption").click();
      }
      $("#specificLabor").hide();
    }
  });
  $("#care").change(function() {
    if ($(this).is(":checked")) {
      $("#specificCare").show();
    } else {
      if ($("#WagOption").is(":checked")) {
        $("#WagOption").click();
      }
      if ($("#RoverOption").is(":checked")) {
        $("#RoverOption").click();
      }
      if ($("#CareOption").is(":checked")) {
        $("#CareOption").click();
      }
      $("#specificCare").hide();
    }
  });
  $("#massage").change(function() {
    if ($(this).is(":checked")) {
      $("#specificMassage").show();
    } else {
      if ($("#ZeelOption").is(":checked")) {
        $("#ZeelOption").click();
      }
      $("#specificMassage").hide();
    }
  });
  $("#language").change(function() {
    if ($(this).is(":checked")) {
      $("#specificLanguage").show();
    } else {
      if ($("LanguageFreelancerOption").is(":checked")) {
        $("#LanguageFreelancerOption").click();
      }
      if ($("ItalkiOption").is(":checked")) {
        $("#ItalkiOption").click();
      }
      $("#specificLanguage").hide();
    }
  });
  $("#writing").change(function() {
    if ($(this).is(":checked")) {
      $("#specificWriting").show();
    } else {
      if ($("#WritingFreelancerOption").is(":checked")) {
        $("#WritingFreelancerOption").click();
      }
      if ($("#WritingUpworkOption").is(":checked")) {
        $("#WritingUpworkOption").click();
      }
      if ($("#WritingFiverrOption").is(":checked")) {
        $("#WritingFiverrOption").click();
      }
      $("#specificWriting").hide();
    }
  });
  $("#art").change(function() {
    if ($(this).is(":checked")) {
      $("#specificArt").show();
    } else {
      if ($("#ArtGraphicsFiverrOption").is(":checked")) {
        $("#ArtGraphicsFiverrOption").click();
      }
      if ($("#VideoGraphicsFiverrOption").is(":checked")) {
        $("#VideoGraphicsFiverrOption").click();
      }
      if ($("#EtsyOption").is(":checked")) {
        $("#EtsyOption").click();
      }
      $("#specificArt").hide();
    }
  });
  $("#music").change(function() {
    if ($(this).is(":checked")) {
      $("#specificMusic").show();
    } else {
      if ($("#BeatStarsOption").is(":checked")) {
        $("#BeatStarsOption").click();
      }
      if ($("#MusicFiverrOption").is(":checked")) {
        $("#MusicFiverrOption").click();
      }
      if ($("#GigFinesseOption").is(":checked")) {
        $("#GigFinesseOption").click();
      }
      $("#specificMusic").hide();
    }
  });
  $("#finance").change(function() {
    if ($(this).is(":checked")) {
      $("#specificFinance").show();
    } else {
      if ($("#FinanceUpworkOption").is(":checked")) {
        $("#FinanceUpworkOption").click();
      }
      if ($("#GraphiteOption").is(":checked")) {
        $("#GraphiteOption").click();
      }
      $("#specificFinance").hide();
    }
  });
  $("#tech").change(function() {
    if ($(this).is(":checked")) {
      $("#specificTech").show();
    } else {
      if ($("#WebFreelancerOption").is(":checked")) {
        $("#WebFreelancerOption").click();
      }
      if ($("#MobileFreelancerOption").is(":checked")) {
        $("#WebFreelancerOption").click();
      }
      if ($("#ITUpworkOption").is(":checked")) {
        $("#ITUpworkOption").click();
      }
      if ($("#WebUpworkOption").is(":checked")) {
        $("#WebUpworkOption").click();
      }
      if ($("#DataUpworkOption").is(":checked")) {
        $("#DataUpworkOption").click();
      }
      if ($("#TechFiverrOption").is(":checked")) {
        $("#TechFiverrOption").click();
      }
      $("#specificTech").hide();
    }
  });
  $("#engineering").change(function() {
    if ($(this).is(":checked")) {
      $("#specificEngineering").show();
    } else {
      if ($("#EngineeringFreelancerOption").is(":checked")) {
        $("#EngineeringUpworkOption").click();
      }
      if ($("#EngineeringUpworkOption").is(":checked")) {
        $("#EngineeringUpworkOption").click();
      }
      $("#specificEngineering").hide();
    }
  });
  $("#business").change(function() {
    if ($(this).is(":checked")) {
      $("#specificBusiness").show();
    } else {
      if ($("#SalesFreelancerOption").is(":checked")) {
        $("#SalesFreelancerOption").click();
      }
      if ($("#BusinessFreelancerOption").is(":checked")) {
        $("#SalesFreelancerOption").click();
      }
      if ($("#SalesUpworkOption").is(":checked")) {
        $("#SalesUpworkOption").click();
      }
      if ($("#MarketingFiverrOption").is(":checked")) {
        $("#MarketingFiverrOption").click();
      }
      if ($("#BusinessFiverrOption").is(":checked")) {
        $("#BusinessFiverrOption").click();
      }
      $("#specificFinance").hide();
    }
  });
  $("#legal").change(function() {
    if ($(this).is(":checked")) {
      $("#specificLegal").show();
    } else {
      if ($("#LegalUpworkOption").is(":checked")) {
        $("#LegalUpworkOption").click();
      }
      $("#specificLegal").hide();
    }
  });
  // Driving
  $("#RideshareOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("UberCard");
      if(arr.length < 3) {
        $(".UberCard").show();
        arr.push("UberCard");
      }
      results.push("LyftCard");
      if(arr.length < 3) {
        $(".LyftCard").show();
        arr.push("LyftCard");
      }
      results.push("HopSkipDriveCard");
      if(arr.length < 3) {
        $(".HopSkipDriveCard").show();
        arr.push("HopSkipDriveCard");
      }
    } else {
      results.remove("UberCard");
      if(arr.includes("UberCard")) {
        $(".UberCard").hide();
        arr.remove("UberCard");
      }
      results.remove("LyftCard");
      if(arr.includes("LyftCard")) {
        $(".LyftCard").hide();
        arr.remove("LyftCard");
      }
      results.remove("HopSkipDriveCard");
      if(arr.includes("HopSkipDriveCard")) {
        $(".HopSkipDriveCard").hide();
        arr.remove("HopSkipDriveCard");
      }
    }
  });
  $("#DeliveryOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("AmazonDeliversDeliveryCard");
      if(arr.length < 3) {
        $(".AmazonDeliversDeliveryCard").show();
        arr.push("AmazonDeliversDeliveryCard");
      }
      results.push("AmazonFlexDeliveryCard");
      if(arr.length < 3) {
        $(".AmazonFlexDeliveryCard").show();
        arr.push("AmazonFlexDeliveryCard");
      }
      results.push("DollyHelpersCard");
      if(arr.length < 3) {
        $(".DollyHelpersCard").show();
        arr.push("DollyHelpersCard");
      }
    } else {
      results.remove("AmazonDeliversDeliveryCard");
      if(arr.includes("AmazonDeliversDeliveryCard")) {
        $(".AmazonDeliversDeliveryCard").hide();
        arr.remove("AmazonDeliversDeliveryCard");
      }
      results.remove("AmazonFlexDeliveryCard");
      if(arr.includes("AmazonFlexDeliveryCard")) {
        $(".AmazonFlexDeliveryCard").hide();
        arr.remove("AmazonFlexDeliveryCard");
      }
      results.remove("DollyHelpersCard");
      if(arr.includes("DollyHelpersCard")) {
        $(".DollyHelpersCard").hide();
        arr.remove("DollyHelpersCard");
      }
    }
  });
  $("#FoodDeliveryOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("Uber_EatsCard");
      if(arr.length < 3) {
        $(".Uber_EatsCard").show();
        arr.push("Uber_EatsCard");
      }
      results.push("GrubhubCard");
      if(arr.length < 3) {
        $(".GrubhubCard").show();
        arr.push("GrubhubCard");
      }
      results.push("DoorDashCard");
      if(arr.length < 3) {
        $(".DoorDashCard").show();
        arr.push("DoorDashCard");
      }
      results.push("CaviarCard");
      if(arr.length < 3) {
        $(".CaviarCard").show();
        arr.push("CaviarCard");
      }
      results.push("PostmatesCard");
      if(arr.length < 3) {
        $(".PostmatesCard").show();
        arr.push("PostmatesCard");
      }
      results.push("WaitrCard");
      if(arr.length < 3) {
        $(".WaitrCard").show();
        arr.push("WaitrCard");
      }
      results.push("Bite_SquadCard");
      if(arr.length < 3) {
        $(".Bite_SquadCard").show();
        arr.push("Bite_SquadCard");
      }
      results.push("FavorCard");
      if(arr.length < 3) {
        $(".FavorCard").show();
        arr.push("FavorCard");
      }
      results.push("Food_DudesCard");
      if(arr.length < 3) {
        $(".Food_DudesCard").show();
        arr.push("Food_DudesCard");
      }
      results.push("FoodjetsCard");
      if(arr.length < 3) {
        $(".FoodjetsCard").show();
        arr.push("FoodjetsCard");
      }
    } else {
      results.remove("Uber_EatsCard");
      if(arr.includes("Uber_EatsCard")) {
        $(".Uber_EatsCard").hide();
        arr.remove("Uber_EatsCard");
      }
      results.remove("GrubhubCard");
      if(arr.includes("GrubhubCard")) {
        $(".GrubhubCard").hide();
        arr.remove("GrubhubCard");
      }
      results.remove("DoorDashCard");
      if(arr.includes("DoorDashCard")) {
        $(".DoorDashCard").hide();
        arr.remove("DoorDashCard");
      }
      results.remove("CaviarCard");
      if(arr.includes("CaviarCard")) {
        $(".CaviarCard").hide();
        arr.remove("CaviarCard");
      }
      results.remove("PostmatesCard");
      if(arr.includes("PostmatesCard")) {
        $(".PostmatesCard").hide();
        arr.remove("PostmatesCard");
      }
      results.remove("WaitrCard");
      if(arr.includes("WaitrCard")) {
        $(".WaitrCard").hide();
        arr.remove("WaitrCard");
      }
      results.remove("Bite_SquadCard");
      if(arr.includes("Bite_SquadCard")) {
        $(".Bite_SquadCard").hide();
        arr.remove("Bite_SquadCard");
      }
      results.remove("FavorCard");
      if(arr.includes("FavorCard")) {
        $(".FavorCard").hide();
        arr.remove("FavorCard");
      }
      results.remove("Food_DudesCard");
      if(arr.includes("Food_DudesCard")) {
        $(".Food_DudesCard").hide();
        arr.remove("Food_DudesCard");
      }
      results.remove("FoodjetsCard");
      if(arr.includes("FoodjetsCard")) {
        $(".FoodjetsCard").hide();
        arr.remove("FoodjetsCard");
      }
    }
  });
  $("#GroceryDeliveryOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("AmazonDeliversShopperCard");
      if(arr.length < 3) {
        $(".AmazonDeliversShopperCard").show();
        arr.push("AmazonDeliversShopperCard");
      }
      results.push("AmazonFlexGroceryCard");
      if(arr.length < 3) {
        $(".AmazonFlexGroceryCard").show();
        arr.push("AmazonFlexGroceryCard");
      }
      results.push("InstacartCard");
      if(arr.length < 3) {
        $(".InstacartCard").show();
        arr.push("InstacartCard");
      }
      results.push("ShiptCard");
      if(arr.length < 3) {
        $(".ShiptCard").show();
        arr.push("ShiptCard");
      }
      results.push("Grocery_ChimpsCard");
      if(arr.length < 3) {
        $(".Grocery_ChimpsCard").show();
        arr.push("Grocery_ChimpsCard");
      }
    } else {
      results.remove("AmazonDeliversShopperCard");
      if(arr.includes("AmazonDeliversShopperCard")) {
        $(".AmazonDeliversShopperCard").hide();
        arr.remove("AmazonDeliversShopperCard");
      }
      results.remove("AmazonFlexGroceryCard");
      if(arr.includes("AmazonFlexGroceryCard")) {
        $(".AmazonFlexGroceryCard").hide();
        arr.remove("AmazonFlexGroceryCard");
      }
      results.remove("InstacartCard");
      if(arr.includes("InstacartCard")) {
        $(".InstacartCard").hide();
        arr.remove("InstacartCard");
      }
      results.remove("ShiptCard");
      if(arr.includes("ShiptCard")) {
        $(".ShiptCard").hide();
        arr.remove("ShiptCard");
      }
      results.remove("Grocery_ChimpsCard");
      if(arr.includes("Grocery_ChimpsCard")) {
        $(".Grocery_ChimpsCard").hide();
        arr.remove("Grocery_ChimpsCard");
      }
    }
  });
  // Labor
  $("#AmazonDeliversWarehouseOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("AmazonDeliversWarehouseCard");
      if(arr.length < 3) {
        $(".AmazonDeliversWarehouseCard").show();
        arr.push("AmazonDeliversWarehouseCard");
      }
    } else {
      results.remove("AmazonDeliversWarehouseCard");
      if(arr.includes("AmazonDeliversWarehouseCard")) {
        $(".AmazonDeliversWarehouseCard").hide();
        arr.remove("AmazonDeliversWarehouseCard");
      }
    }
  });
  $("#DollyHandsOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("DollyHandsCard");
      if(arr.length < 3) {
        $(".DollyHandsCard").show();
        arr.push("DollyHandsCard");
      }
    } else {
      results.remove("DollyHandsCard");
      if(arr.includes("DollyHandsCard")) {
        $(".DollyHandsCard").hide();
        arr.remove("DollyHandsCard");
      }
    }
  });
  $("#TaskEasyOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("TaskEasyCard");
      if(arr.length < 3) {
        $(".TaskEasyCard").show();
        arr.push("TaskEasyCard");
      }
    } else {
      results.remove("TaskEasyCard");
      if(arr.includes("TaskEasyCard")) {
        $(".TaskEasyCard").hide();
        arr.remove("TaskEasyCard");
      }
    }
  });
  $("#HandyOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("HandyCard");
      if(arr.length < 3) {
        $(".HandyCard").show();
        arr.push("HandyCard");
      }
    } else {
      results.remove("HandyCard");
      if(arr.includes("HandyCard")) {
        $(".HandyCard").hide();
        arr.remove("HandyCard");
      }
    }
  });
  // Care
  $("#WagOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("WagCard");
      if(arr.length < 3) {
        $(".WagCard").show();
        arr.push("WagCard");
      }
    } else {
      results.remove("WagCard");
      if(arr.includes("WagCard")) {
        $(".WagCard").hide();
        arr.remove("WagCard");
      }
    }
  });
  $("#RoverOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("RoverCard");
      if(arr.length < 3) {
        $(".RoverCard").show();
        arr.push("RoverCard");
      }
    } else {
      results.remove("RoverCard");
      if(arr.includes("RoverCard")) {
        $(".RoverCard").hide();
        arr.remove("RoverCard");
      }
    }
  });
  $("#CareOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("CareCard");
      if(arr.length < 3) {
        $(".CareCard").show();
        arr.push("CareCard");
      }
    } else {
      results.remove("CareCard");
      if(arr.includes("CareCard")) {
        $(".CareCard").hide();
        arr.remove("CareCard");
      }
    }
  });
  // Massage
  $("#ZeelOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("ZeelCard");
      if(arr.length < 3) {
        $(".ZeelCard").show();
        arr.push("ZeelCard");
      }
    } else {
      results.remove("ZeelCard");
      if(arr.includes("ZeelCard")) {
        $(".ZeelCard").hide();
        arr.remove("ZeelCard");
      }
    }
  });
  // Language
  $("#LanguageFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("LanguageFreelancerCard");
      if(arr.length < 3) {
        $(".LanguageFreelancerCard").show();
        arr.push("LanguageFreelancerCard");
      }
    } else {
      results.remove("LanguageFreelancerCard");
      if(arr.includes("LanguageFreelancerCard")) {
        $(".LanguageFreelancerCard").hide();
        arr.remove("LanguageFreelancerCard");
      }
    }
  });
  $("#ItalkiOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("ItalkiCard");
      if(arr.length < 3) {
        $(".ItalkiCard").show();
        arr.push("ItalkiCard");
      }
    } else {
      results.remove("ItalkiCard");
      if(arr.includes("ItalkiCard")) {
        $(".ItalkiCard").hide();
        arr.remove("ItalkiCard");
      }
    }
  });
  // Writing
  $("#WritingFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("WritingFreelancerCard");
      if(arr.length < 3) {
        $(".WritingFreelancerCard").show();
        arr.push("WritingFreelancerCard");
      }
    } else {
      results.remove("WritingFreelancerCard");
      if(arr.includes("WritingFreelancerCard")) {
        $(".WritingFreelancerCard").hide();
        arr.remove("WritingFreelancerCard");
      }
    }
  });
  $("#WritingUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("WritingUpworkCard");
      if(arr.length < 3) {
        $(".WritingUpworkCard").show();
        arr.push("WritingUpworkCard");
      }
    } else {
      results.remove("WritingUpworkCard");
      if(arr.includes("WritingUpworkCard")) {
        $(".WritingUpworkCard").hide();
        arr.remove("WritingUpworkCard");
      }
    }
  });
  $("#WritingFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("WritingFiverrCard");
      if(arr.length < 3) {
        $(".WritingFiverrCard").show();
        arr.push("WritingFiverrCard");
      }
    } else {
      results.remove("WritingFiverrCard");
      if(arr.includes("WritingFiverrCard")) {
        $(".WritingFiverrCard").hide();
        arr.remove("WritingFiverrCard");
      }
    }
  });
  // Art
  $("#ArtGraphicsFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("ArtGraphicsFiverrCard");
      if(arr.length < 3) {
        $(".ArtGraphicsFiverrCard").show();
        arr.push("ArtGraphicsFiverrCard");
      }
    } else {
      results.remove("ArtGraphicsFiverrCard");
      if(arr.includes("ArtGraphicsFiverrCard")) {
        $(".ArtGraphicsFiverrCard").hide();
        arr.remove("ArtGraphicsFiverrCard");
      }
    }
  });
  $("#ArtVideoFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("ArtVideoFiverrCard");
      if(arr.length < 3) {
        $(".ArtVideoFiverrCard").show();
        arr.push("ArtVideoFiverrCard");
      }
    } else {
      results.remove("ArtVideoFiverrCard");
      if(arr.includes("ArtVideoFiverrCard")) {
        $(".ArtVideoFiverrCard").hide();
        arr.remove("ArtVideoFiverrCard");
      }
    }
  });
  $("#EtsyOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("EtsyCard");
      if(arr.length < 3) {
        $(".EtsyCard").show();
        arr.push("EtsyCard");
      }
    } else {
      results.remove("EtsyCard");
      if(arr.includes("EtsyCard")) {
        $(".EtsyCard").hide();
        arr.remove("EtsyCard");
      }
    }
  });
  // Music
  $("#BeatStarsOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("BeatStarsCard");
      if(arr.length < 3) {
        $(".BeatStarsCard").show();
        arr.push("BeatStarsCard");
      }
    } else {
      results.remove("BeatStarsCard");
      if(arr.includes("BeatStarsCard")) {
        $(".BeatStarsCard").hide();
        arr.remove("BeatStarsCard");
      }
    }
  });
  $("#MusicFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("MusicFiverrCard");
      if(arr.length < 3) {
        $(".MusicFiverrCard").show();
        arr.push("MusicFiverrCard");
      }
    } else {
      results.remove("MusicFiverrCard");
      if(arr.includes("MusicFiverrCard")) {
        $(".MusicFiverrCard").hide();
        arr.remove("MusicFiverrCard");
      }
    }
  });
  $("#GigFinesseOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("GigFinesseCard");
      if(arr.length < 3) {
        $(".GigFinesseCard").show();
        arr.push("GigFinesseCard");
      }
    } else {
      results.remove("GigFinesseCard");
      if(arr.includes("GigFinesseCard")) {
        $(".GigFinesseCard").hide();
        arr.remove("GigFinesseCard");
      }
    }
  });
  // Finance
  $("#FinanceUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("FinanceUpworkCard");
      if(arr.length < 3) {
        $(".FinanceUpworkCard").show();
        arr.push("FinanceUpworkCard");
      }
    } else {
      results.remove("FinanceUpworkCard");
      if(arr.includes("FinanceUpworkCard")) {
        $(".FinanceUpworkCard").hide();
        arr.remove("FinanceUpworkCard");
      }
    }
  });
  $("#GraphiteOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("GraphiteCard");
      if(arr.length < 3) {
        $(".GraphiteCard").show();
        arr.push("GraphiteCard");
      }
    } else {
      results.remove("GraphiteCard");
      if(arr.includes("GraphiteCard")) {
        $(".GraphiteCard").hide();
        arr.remove("GraphiteCard");
      }
    }
  });
  // Tech
  $("#WebFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("WebFreelancerCard");
      if(arr.length < 3) {
        $(".WebFreelancerCard").show();
        arr.push("WebFreelancerCard");
      }
    } else {
      results.remove("WebFreelancerCard");
      if(arr.includes("WebFreelancerCard")) {
        $(".WebFreelancerCard").hide();
        arr.remove("WebFreelancerCard");
      }
    }
  });
  $("#MobileFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("MobileFreelancerCard");
      if(arr.length < 3) {
        $(".MobileFreelancerCard").show();
        arr.push("MobileFreelancerCard");
      }
    } else {
      results.remove("MobileFreelancerCard");
      if(arr.includes("MobileFreelancerCard")) {
        $(".MobileFreelancerCard").hide();
        arr.remove("MobileFreelancerCard");
      }
    }
  });
  $("#ITUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("ITUpworkCard");
      if(arr.length < 3) {
        $(".ITUpworkCard").show();
        arr.push("ITUpworkCard");
      }
    } else {
      results.remove("ITUpworkCard");
      if(arr.includes("ITUpworkCard")) {
        $(".ITUpworkCard").hide();
        arr.remove("ITUpworkCard");
      }
    }
  });
  $("#WebUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("WebUpworkCard");
      if(arr.length < 3) {
        $(".WebUpworkCard").show();
        arr.push("WebUpworkCard");
      }
    } else {
      results.remove("WebUpworkCard");
      if(arr.includes("WebUpworkCard")) {
        $(".WebUpworkCard").hide();
        arr.remove("WebUpworkCard");
      }
    }
  });
  $("#DataUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("DataUpworkCard");
      if(arr.length < 3) {
        $(".DataUpworkCard").show();
        arr.push("DataUpworkCard");
      }
    } else {
      results.remove("DataUpworkCard");
      if(arr.includes("DataUpworkCard")) {
        $(".DataUpworkCard").hide();
        arr.remove("DataUpworkCard");
      }
    }
  });
  $("#TechFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("TechFiverrCard");
      if(arr.length < 3) {
        $(".TechFiverrCard").show();
        arr.push("TechFiverrCard");
      }
    } else {
      results.remove("TechFiverrCard");
      if(arr.includes("TechFiverrCard")) {
        $(".TechFiverrCard").hide();
        arr.remove("TechFiverrCard");
      }
    }
  });
  // Engineering
  $("#EngineeringFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("EngineeringFreelancerCard");
      if(arr.length < 3) {
        $(".EngineeringFreelancerCard").show();
        arr.push("EngineeringFreelancerCard");
      }
    } else {
      results.remove("EngineeringFreelancerCard");
      if(arr.includes("EngineeringFreelancerCard")) {
        $(".EngineeringFreelancerCard").hide();
        arr.remove("EngineeringFreelancerCard");
      }
    }
  });
  $("#EngineeringUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("EngineeringUpworkCard");
      if(arr.length < 3) {
        $(".EngineeringUpworkCard").show();
        arr.push("EngineeringUpworkCard");
      }
    } else {
      results.remove("EngineeringUpworkCard");
      if(arr.includes("EngineeringUpworkCard")) {
        $(".EngineeringUpworkCard").hide();
        arr.remove("EngineeringUpworkCard");
      }
    }
  });
  // Business
  $("#SalesFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("SalesFreelancerCard");
      if(arr.length < 3) {
        $(".SalesFreelancerCard").show();
        arr.push("SalesFreelancerCard");
      }
    } else {
      results.remove("SalesFreelancerCard");
      if(arr.includes("SalesFreelancerCard")) {
        $(".SalesFreelancerCard").hide();
        arr.remove("SalesFreelancerCard");
      }
    }
  });
  $("#BusinessFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("BusinessFreelancerCard");
      if(arr.length < 3) {
        $(".BusinessFreelancerCard").show();
        arr.push("BusinessFreelancerCard");
      }
    } else {
      results.remove("BusinessFreelancerCard");
      if(arr.includes("BusinessFreelancerCard")) {
        $(".BusinessFreelancerCard").hide();
        arr.remove("BusinessFreelancerCard");
      }
    }
  });
  $("#SalesUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("SalesUpworkCard");
      if(arr.length < 3) {
        $(".SalesUpworkCard").show();
        arr.push("SalesUpworkCard");
      }
    } else {
      results.remove("SalesUpworkCard");
      if(arr.includes("SalesUpworkCard")) {
        $(".SalesUpworkCard").hide();
        arr.remove("SalesUpworkCard");
      }
    }
  });
  $("#MarketingFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("MarketingFiverrCard");
      if(arr.length < 3) {
        $(".MarketingFiverrCard").show();
        arr.push("MarketingFiverrCard");
      }
    } else {
      results.remove("MarketingFiverrCard");
      if(arr.includes("MarketingFiverrCard")) {
        $(".MarketingFiverrCard").hide();
        arr.remove("MarketingFiverrCard");
      }
    }
  });
  $("#BusinessFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("BusinessFiverrCard");
      if(arr.length < 3) {
        $(".BusinessFiverrCard").show();
        arr.push("BusinessFiverrCard");
      }
    } else {
      results.remove("BusinessFiverrCard");
      if(arr.includes("BusinessFiverrCard")) {
        $(".BusinessFiverrCard").hide();
        arr.remove("BusinessFiverrCard");
      }
    }
  });
  // Legal
  $("#LegalUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("LegalUpworkCard");
      if(arr.length < 3) {
        $(".LegalUpworkCard").show();
        arr.push("LegalUpworkCard");
      }
    } else {
      results.remove("LegalUpworkCard");
      if(arr.includes("LegalUpworkCard")) {
        $(".LegalUpworkCard").hide();
        arr.remove("LegalUpworkCard");
      }
    }
  });
  // Assets
  $("#AssetCarOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("TuroCard");
      if(arr.length < 3) {
        $(".TuroCard").show();
        arr.push("TuroCard");
      }
      results.push("GetaroundCard");
      if(arr.length < 3) {
        $(".GetaroundCard").show();
        arr.push("GetaroundCard");
      }
    } else {
      results.remove("TuroCard");
      if(arr.includes("TuroCard")) {
        $(".TuroCard").hide();
        arr.remove("TuroCard");
      }
      results.remove("GetaroundCard");
      if(arr.includes("GetaroundCard")) {
        $(".GetaroundCard").hide();
        arr.remove("GetaroundCard");
      }
    }
  });
  $("#AirbnbOption").change(function() {
    if ($(this).is(":checked")) {
      results.push("AirbnbCard");
      if(arr.length < 3) {
        $(".AirbnbCard").show();
        arr.push("AirbnbCard");
      }
    } else {
      results.remove("AirbnbCard");
      if(arr.includes("AirbnbCard")) {
        $(".AirbnbCard").hide();
        arr.remove("AirbnbCard");
      }
    }
  });
});